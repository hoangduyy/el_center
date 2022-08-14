import { css } from "@emotion/react";
import {
    Button, Form,
    Input
} from "antd";
import React, { useState } from "react";
import { useQuery } from "react-query";

const ContactForm = ({ onFinish, isEdit, ...props }) => {
    const [form] = Form.useForm();

    const { isLoading, data } = useQuery(["category"], async () => {
        const { data } = await axios.get("/api/admin/category");
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
                label="Tên danh mục"
                rules={[
                    {
                        required: true,
                        message: "Vui lòng nhập tên danh mục",
                    },
                ]}
            >
                <Input />
            </Form.Item>

            <Form.Item className="float-right">
                <Button type="primary" htmlType="submit">
                    {isEdit ? "Cập nhật" : "Thêm mới"}
                </Button>
            </Form.Item>
        </Form>
    );
};

export default ContactForm;
