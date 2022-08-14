import { css } from "@emotion/react";
import {
    Button, Form,
    Input
} from "antd";
import React, { useState } from "react";
import { useQuery } from "react-query";

const { TextArea } = Input;
const CertificateForm = ({ onFinish, isEdit, ...props }) => {
    const [form] = Form.useForm();

    const { isLoading, data } = useQuery(["certificate"], async () => {
        const { data } = await axios.get("/api/admin/certificate");
        return data;
    });

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
                label="Tên chứng chỉ"
                rules={[
                    {
                        required: true,
                        message: "Vui lòng nhập tên chứng chỉ",
                    },
                ]}
            >
                <Input />
            </Form.Item>
            <Form.Item
                name="description"
                label="Mô tả"
            >
                <TextArea row={6} />
            </Form.Item>

            <Form.Item className="float-right">
                <Button type="primary" htmlType="submit">
                    {isEdit ? "Cập nhật" : "Thêm mới"}
                </Button>
            </Form.Item>
        </Form>
    );
};

export default CertificateForm;
