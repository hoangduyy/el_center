import { Form, Input, Button, Row, Col, message } from "antd";
import { css } from "@emotion/react";
import { ReloadOutlined } from "@ant-design/icons";
import { useQuery } from "react-query";
import React, { useState, useEffect, useRef } from "react";
import MonacoEditor from "react-monaco-editor";
import MailjetSelect from "../../components/mailjet-select";

const CampaignForm = ({ onFinish, isEdit, ...props }) => {
    const [form] = Form.useForm();
    const [selectedTemplateId, setSelectedTemplateId] = useState(null);
    const [html, setHtml] = useState(props.initialValues?.html);
    const editor = useRef(null);

    const {
        isLoading,
        data: detailData,
        refetch,
        isError,
    } = useQuery(
        ["template", selectedTemplateId],
        async () => {
            try {
                if (selectedTemplateId) {
                    const { data } = await axios.get(
                        "/api/admin/mailjet/" + selectedTemplateId
                    );
                    if (data && data.length > 0) {
                        setHtml(data[0]["Html-part"]);
                        setTimeout(function () {
                            editor.current
                                .getAction("editor.action.format")
                                .run();
                        }, 500);
                    }
                    return data;
                }
            } catch (e) {
                message.error(
                    "Không thể tải dữ liệu từ template này.Vui lòng kiểm tra trạng thái của template từ mailjet"
                );
            }
            return null;
        },
        {
            enabled: !!selectedTemplateId,
        }
    );

    useEffect(() => {
        refetch();
    }, [selectedTemplateId]);

    console.log(detailData);
    return (
        <Form
            labelCol={{
                span: 5,
            }}
            css={css`
                width: 100%;
            `}
            form={form}
            onFinish={(values) => {
                onFinish({
                    ...values,
                    html,
                });
            }}
            scrollToFirstError
            {...props}
        >
            <Form.Item
                css={css`
                    width: 50%;
                `}
                name="name"
                label="Tên mẫu"
                rules={[
                    {
                        required: true,
                        message: "Vui lòng nhập tên mẫu",
                    },
                ]}
            >
                <Input />
            </Form.Item>
            <Form.Item
                css={css`
                    width: 50%;
                `}
                name="name"
                name={"mailjet_id"}
                label="Mailjet Template"
            >
                <Row>
                    <Col span={22}>
                        <MailjetSelect
                            onChange={(value) => setSelectedTemplateId(value)}
                        />
                    </Col>
                    <Col span={2}>
                        <Button onClick={() => refetch()}>
                            <ReloadOutlined />
                        </Button>
                    </Col>
                </Row>
            </Form.Item>
            <Row>
                <Col span={12}>
                    <MonacoEditor
                        ref={editor}
                        width="100%"
                        height="600"
                        language="html"
                        theme="vs-dark"
                        value={html}
                        options={{
                            selectOnLineNumbers: true,
                            automaticLayout: true,
                            autoIndent: true,
                            formatOnPaste: true,
                            formatOnType: true,
                            minimap: {
                                enabled: false,
                            },
                        }}
                        onChange={(value) => setHtml(value)}
                    />
                </Col>
                <Col span={12}>
                    <iframe
                        id="preview"
                        srcDoc={html}
                        css={css`
                            width: 100%;
                            height: 600px;
                            border: none;
                        `}
                    />
                </Col>
            </Row>
            <Form.Item className="float-right">
                <Button type="primary" htmlType="submit">
                    {isEdit ? "Cập nhật" : "Thêm mới"}
                </Button>
            </Form.Item>
        </Form>
    );
};

export default CampaignForm;
