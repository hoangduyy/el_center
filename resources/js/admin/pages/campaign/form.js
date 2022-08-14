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
} from "antd";
import { css } from "@emotion/react";
import {
    InboxOutlined,
    PlusOutlined,
    MinusCircleOutlined,
} from "@ant-design/icons";
import { useQuery } from "react-query";
import React, { useState, useEffect } from "react";
import TemplateSelect from "../../components/template-select";

const CampaignForm = ({ onFinish, isEdit, ...props }) => {
    const [form] = Form.useForm();
    const [defaultFileList, setDefaultFileList] = useState(
        props.initialValues
            ? [
                  {
                      id: -1,
                      status: "done",
                      url: asset("storage/" + props.initialValues.banner),
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
                    url: asset("storage/" + file.response),
                },
            ]);
        }
    };

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
                name="name"
                label="Tên chiến dịch"
                rules={[
                    {
                        required: true,
                        message: "Vui lòng nhập tên chiến dịch",
                    },
                ]}
            >
                <Input />
            </Form.Item>
            <Form.Item
                name="url"
                label="Link khoá học"
                rules={[
                    {
                        required: true,
                        message: "Vui lòng nhập link chiến dịch",
                    },
                ]}
            >
                <Input type="url" />
            </Form.Item>
            <Form.Item name="slug" label="Slug">
                <Input />
            </Form.Item>
            <Form.Item label="Banner">
                {defaultFileList.length > 0 && (
                    <Image src={defaultFileList[0].url} />
                )}
                <Form.Item
                    rules={[
                        {
                            required: true,
                            message: "Vui lòng tải banner cho chiến dịch",
                        },
                    ]}
                    name="banner"
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

            <Form.List name="templates" label="Mẫu email">
                {(fields, { add, remove }, { errors }) => (
                    <>
                        <Form.Item label={"Mẫu Email"}>
                            {fields.map(
                                (
                                    { key, name, fieldKey, ...restField },
                                    index
                                ) => {
                                    return (
                                        <React.Fragment key={key}>
                                            <Row>
                                                <Col span={10}>
                                                    <Form.Item
                                                        {...restField}
                                                        name={[
                                                            name,
                                                            "template_id",
                                                        ]}
                                                        fieldKey={[
                                                            fieldKey,
                                                            "template_id",
                                                        ]}
                                                        className="mb-1"
                                                    >
                                                        <TemplateSelect placeholder="Mẫu email" />
                                                    </Form.Item>
                                                </Col>
                                                <Col span={10}>
                                                    <Form.Item
                                                        {...restField}
                                                        name={[name, "subject"]}
                                                        fieldKey={[
                                                            fieldKey,
                                                            "subject",
                                                        ]}
                                                        className="mb-1"
                                                    >
                                                        <Input placeholder="Tiêu đề email" />
                                                    </Form.Item>
                                                </Col>
                                                <Col span={3}>
                                                    <Form.Item
                                                        {...restField}
                                                        name={[
                                                            name,
                                                            "number_invited",
                                                        ]}
                                                        fieldKey={[
                                                            fieldKey,
                                                            "number_invited",
                                                        ]}
                                                    >
                                                        <Input
                                                            placeholder="Số người đã mời"
                                                            type="number"
                                                        />
                                                    </Form.Item>
                                                </Col>
                                                <Col span={1}>
                                                    <MinusCircleOutlined
                                                        onClick={() =>
                                                            remove(name)
                                                        }
                                                        css={css`
                                                            color: red;
                                                            margin-top: 10px;
                                                            margin-left: 8px;
                                                            cursor: pointer;
                                                        `}
                                                    />
                                                </Col>
                                            </Row>
                                            <Divider dashed />
                                        </React.Fragment>
                                    );
                                }
                            )}
                            <div>
                                <Button
                                    type="dashed"
                                    onClick={() =>
                                        add({
                                            template_id: null,
                                            count: 0,
                                        })
                                    }
                                    icon={<PlusOutlined />}
                                >
                                    Thêm mẫu email
                                </Button>
                            </div>
                        </Form.Item>
                    </>
                )}
            </Form.List>
            <Form.Item className="float-right">
                <Button type="primary" htmlType="submit">
                    {isEdit ? "Cập nhật" : "Thêm mới"}
                </Button>
            </Form.Item>
        </Form>
    );
};

export default CampaignForm;
