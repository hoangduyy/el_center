import { css } from "@emotion/react";
import { Button, Form, Input } from "antd";
import React, { useState } from "react";
import { useQuery } from "react-query";

const LevelForm = ({ onFinish, isEdit, ...props }) => {
    const [form] = Form.useForm();

    const { isLoading, data } = useQuery(["level"], async () => {
        const { data } = await axios.get("/api/admin/level");
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
                label="Tên trình độ"
                rules={[
                    {
                        required: true,
                        message: "Vui lòng nhập tên trình độ",
                    },
                ]}
            >
                <Input />
            </Form.Item>

            <Form.Item
                name="description"
                label="Mô tả"
                rules={[
                    {
                        required: true,
                        message: "Vui lòng nhập mô tả",
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

export default LevelForm;
