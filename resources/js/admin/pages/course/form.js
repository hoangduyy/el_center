import { css } from "@emotion/react";
import {
    Form,
    Input,
    Button,
    Upload,
    Progress,
    Image,
    Switch,
    InputNumber,
    Select,
    DatePicker,
    Tag,
} from "antd";
import React, { useEffect, useState } from "react";
import { InboxOutlined } from "@ant-design/icons";
import { CKEditor } from "@ckeditor/ckeditor5-react";
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";
import moment from "moment";

const { TextArea } = Input;
const { Option } = Select;
const listOption = ["Điều hoà", "Wifi", "Giáo viên nước ngoài"];
const children = [];
for (let i = 0; i < listOption.length; i++) {
    children.push(<Option key={listOption[i]}>{listOption[i]}</Option>);
}

const dateFormat = "YYYY-MM-DD hh:mm:ii";
const CourseForm = ({
    onFinish,
    isEdit,
    getContent,
    onChecked,
    onEditor,
    onChangeDate,
    onChangeHours,
    onChangePrice,
    onChangeLectures,
    onChangeUltilities,
    ...props
}) => {
    const [form] = Form.useForm();
    const [levels, setLevels] = useState([]);
    const handleOnFinish = (value) => {
        onFinish(value);
    };

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

    useEffect(async () => {
        const { data } = await axios.get("/api/admin/level");
        setLevels(data.data);
    }, []);

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
        onChecked(checked);
    };

    const handleGetContent = (data) => {
        onEditor(data);
    };

    const handleChangeDate = (data) => {
        onChangeDate(data);
    };

    const handleChangeHours = (data) => {
        onChangeHours(data);
    };

    const handleChangePrice = (data) => {
        onChangePrice(data);
    };

    const handleChangeLectures = (data) => {
        onChangeLectures(data);
    };

    const handleChangeUltilities = (data) => {
        onChangeUltilities(data);
    };

    function tagRender(props) {
        const { label,color, value, closable, onClose } = props;
        const onPreventMouseDown = (event) => {
            event.preventDefault();
            event.stopPropagation();
        };
        return (
            <Tag
                color={color}
                onMouseDown={onPreventMouseDown}
                closable={closable}
                onClose={onClose}
                style={{ marginRight: 3 }}
            >
                {label}
            </Tag>
        );
    }

    const options = [
        {label:'Giảng viên Việt Nam', color: "orange", value: "Giảng viên Việt Nam" },
        {label:'Giảng viên nước ngoài', color: "lime", value: "Giảng viên nước ngoài" },
        {label:'Wifi', color: "green", value: "Wifi" },
        {label:'Diều hoà', color: "cyan", value: "Điều hoà" },
    ];

    return (
        <>
            <Form
                css={css`
                    width: 600px;
                `}
                labelCol={{
                    span: 6,
                }}
                form={form}
                onFinish={handleOnFinish}
                scrollToFirstError
                {...props}
                initialValues={props.initialValues || {}}
            >
                <Form.Item
                    name="title"
                    label="Tên khoá học"
                    rules={[
                        {
                            required: true,
                            message: "Vui lòng nhập tiêu đề",
                        },
                    ]}
                >
                    <Input />
                </Form.Item>
                <Form.Item label="Ảnh đại diện">
                    {defaultFileList.length > 0 && (
                        <Image src={defaultFileList[0].url} />
                    )}
                    <Form.Item
                        rules={[
                            {
                                required: true,
                                message:
                                    "Vui lòng tải ảnh đại diện cho khoá học",
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
                            {progress > 0 ? (
                                <Progress percent={progress} />
                            ) : null}
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
                    <Input  />
                </Form.Item>
                <Form.Item
                    className="control-75"
                    name="content"
                    label="Nội dung khoá học"
                    rules={[
                        {
                            required: true,
                            message: "Vui lòng nhập nội dung khoá học",
                        },
                    ]}
                >
                    <CKEditor
                        className="content"
                        editor={ClassicEditor}
                        data={
                            props.initialValues
                                ? props.initialValues?.content
                                : ""
                        }
                        onChange={(event, editor) => {
                            const data = editor.getData();
                            handleGetContent(data);
                        }}
                    />
                </Form.Item>

                <Form.Item
                    name="description"
                    label="Mô tả"
                    defaultValue={
                        props.initialValues
                            ? props.initialValues.description
                            : ""
                    }
                >
                    <TextArea row={6} />
                </Form.Item>

                <Form.Item
                    label="Số giờ"
                    rules={[
                        {
                            required: true,
                            message: "Vui lòng nhập số giờ",
                        },
                    ]}
                >
                    <InputNumber
                        defaultValue={
                            props.initialValues
                                ? props.initialValues.number_of_hours
                                : ""
                        }
                        onChange={handleChangeHours}
                    />{" "}
                    <span>giờ</span>
                </Form.Item>

                <Form.Item
                    label="Giá"
                    rules={[
                        {
                            required: true,
                            message: "Vui lòng nhập giá",
                        },
                    ]}
                >
                    <InputNumber
                        defaultValue={
                            props.initialValues ? props.initialValues.price : ""
                        }
                        onChange={handleChangePrice}
                    />
                    <span> đ</span>
                </Form.Item>

                <Form.Item
                    label="Số bài học"
                    rules={[
                        {
                            required: true,
                            message: "Vui lòng nhập bài học",
                        },
                    ]}
                >
                    <InputNumber
                        defaultValue={
                            props.initialValues
                                ? props.initialValues.lectures
                                : ""
                        }
                        onChange={handleChangeLectures}
                    />
                </Form.Item>

                

                <Form.Item
                    label="Ngày bắt đầu"
                    rules={[
                        {
                            required: true,
                            message: "Vui lòng nhập ngày bắt đầu",
                        },
                    ]}
                >
                    <DatePicker
                        defaultValue={
                            props.initialValues
                                ? moment(
                                      new Date(props.initialValues.start_date),
                                      "DD/MM/YYYY"
                                  )
                                : ""
                        }
                        onChange={handleChangeDate}
                    />
                </Form.Item>

                <Form.Item name="utilities" label="Tiện ích" className="control-75">
                    <Select
                        mode="multiple"
                        showArrow
                        tagRender={tagRender}
                        style={{ width: "100%" }}
                        options={options}
                        onChange={handleChangeUltilities}

                    />
                </Form.Item>

                <Form.Item name="level_id" label="Trình độ">
                    <Select
                        showSearch
                        allowClear
                        filterOption={(inputValue, option) =>
                            option.props.children
                                .toString()
                                .toLowerCase()
                                .includes(inputValue.toLowerCase())
                        }
                    >
                        {levels.map((item, key) => (
                            <Select.Option value={item.id} key={item.id}>
                                {item.name}
                            </Select.Option>
                        ))}
                    </Select>
                </Form.Item>

                <Form.Item
                    name="status"
                    label="Trạng thái"
                    valuePropName="checked"
                >
                    <Switch
                        defaultChecked
                        onChange={(checked) => handleChecked(checked)}
                    />
                </Form.Item>

                <Form.Item className="float-right">
                    <Button type="primary" htmlType="submit">
                        {isEdit ? "Cập nhật" : "Thêm mới"}
                    </Button>
                </Form.Item>
            </Form>
        </>
    );
};

export default CourseForm;
