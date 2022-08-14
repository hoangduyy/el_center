import { css } from "@emotion/react";
import {
    Form,
    Input,
    Button,
    Upload,
    Progress,
    Image,
    Spin,
    Row,
    Col,
    Divider,
    Switch,
    Select,
} from "antd";
import React, { useState, useEffect } from "react";
import { useQuery } from "react-query";
import {
    InboxOutlined,
    PlusOutlined,
    MinusCircleOutlined,
} from "@ant-design/icons";
import { CKEditor } from "@ckeditor/ckeditor5-react";
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";

const { TextArea } = Input;
const { Option } = Select;


const BlogPostForm = ({ onFinish, isEdit, onChecked, onEditor, ...props }) => {
    const [data, setData] = useState([]);
    const [blogCategory, setBlogCategory] = useState([[data[0]?.id]]);

    useEffect(async () => {
        await axios.get("/api/admin/blog-category/").then((data) => {
            setData(data.data.data);
            console.log(data.data.data);
        });

    }, []);


    const [form] = Form.useForm();







    const [defaultFileList, setDefaultFileList] = useState(
        props.initialValues
            ? [
                {
                    id: -1,
                    status: "done",
                    url: props.initialValues.thumbnail,
                },
            ]
            : []
    );

    const [progress, setProgress] = useState(0);

    const uploadImage = async (options) => {
        const { onSuccess, onError, file, onProgress } = options;

        const fmData = new FormData();
        const config = {
            headers: { "content-type": "multipart/form-data" },
            onUploadProgress: (event) => {
                const percent = Math.floor((event.loaded / event.total) * 100);
                setProgress(percent);
                if (percent === 100) {
                    setTimeout(() => setProgress(0), 1000);
                }
                onProgress({ percent: (event.loaded / event.total) * 100 });
            },
        };
        fmData.append("file", file);
        try {
            const res = await axios.post("/api/admin/upload", fmData, config);

            return onSuccess(res.data.file);
        } catch (err) {
            console.log("Eroor: ", err);
            const error = new Error("Some error");
            onError({ err });
        }
    };

    const handleOnChange = ({ file, fileList, event }) => {
        if (file.status == "done") {
            setDefaultFileList([
                {
                    id: file.uid,
                    status: "done",
                    url: file.response,
                },
            ]);
        }
    };

    const handleChecked = (checked) => {
        setIsActive(checked);
        props.onChecked(checked)
    }

    const handleGetContent = (data) => {
        props.onEditor(data)
    }

    return (
        <Form
            css={css`
                width: 600px;
            `}
            labelCol={{
                span: 6,
            }}
            form={form}
            onFinish={onFinish}
            scrollToFirstError
            {...props}
        >
            <Form.Item
                name="title"
                label="Tên tiêu đề"
                rules={[
                    {
                        required: true,
                        message: "Vui lòng nhập tiêu đề",
                    },
                ]}
            >
                <Input />
            </Form.Item>
            <Form.Item
                name="blog_categories"
                label="Tên danh mục"
                rules={[
                    {
                        required: true,
                        message: "Vui lòng nhập danh mục",
                    },
                ]}
            >
                <Select
                    name="blog_categories"
                    defaultValue={data[0]?.id}
                    showSearch
                    optionFilterProp="children"
                    onChange={(value) => setBlogCategory(value)}
                    filterOption={(input, option) =>
                        option.children.toLowerCase().indexOf(input.toLowerCase()) >= 0
                    }
                >
                    {data.map((item) => (
                        <Option key={item.id} value={item.id}>
                            {item.name}
                        </Option>
                    ))}
                </Select>
            </Form.Item>
            <Form.Item label="Ảnh đại diện">
                {defaultFileList.length > 0 && (
                    <Image src={defaultFileList[0].url} />
                )}
                <Form.Item
                    rules={[
                        {
                            required: true,
                            message: "Vui lòng tải ảnh đại diện cho bài viết",
                        },
                    ]}
                    name="thumbnail"
                    valuePropName="file"
                    getValueFromEvent={(e) => e && e.file.response}
                    noStyle
                >
                    <Upload.Dragger
                        name="file"
                        accept="image/*"
                        multiple={false}
                        customRequest={uploadImage}
                        onChange={handleOnChange}
                        listType="picture-card"
                        defaultFileList={defaultFileList}
                        className="image-upload-grid"
                        showUploadList={false}
                    >
                        <div>
                            <p className="ant-upload-drag-icon">
                                <InboxOutlined />
                            </p>
                            <p className="ant-upload-text">
                                Kéo ảnh vào để tải ảnh lên
                            </p>
                        </div>
                        {progress > 0 ? <Progress percent={progress} /> : null}
                    </Upload.Dragger>
                </Form.Item>
            </Form.Item>
            <Form.Item
                name="slug"
                label="Đường dẫn"
                rules={[
                    {
                        message: "Vui lòng nhập đường dẫn",
                    },
                ]}
            >
                <Input />
            </Form.Item>

            <Form.Item className="control-75" name="content" label="Nội dung bài viết" rules={[
                {
                    required: true,
                    message: "Vui lòng nhập nội dung bài viết",
                },
            ]}>
                <CKEditor
                    className="content"
                    editor={ClassicEditor}
                    data={props.initialValues ? props.initialValues?.content : ""}
                    onChange={(event, editor) => {
                        const data = editor.getData();
                        // setContent(data);
                        handleGetContent(data)
                    }}
                />
            </Form.Item>

            <Form.Item name="description" label="Mô tả">
                <TextArea row={6} />
            </Form.Item>

            <Form.Item name="status" label="Trạng thái" valuePropName="checked">
                <Switch defaultChecked={props.initialValues === 1 ? props.initialValues?.status : true} onChange={(checked) => handleChecked(checked)} />
            </Form.Item>

            <Form.Item className="float-right">
                <Button type="primary" htmlType="submit">
                    {isEdit ? "Cập nhật" : "Thêm mới"}
                </Button>
            </Form.Item>
        </Form>
    );
};

export default BlogPostForm;
1