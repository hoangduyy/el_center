import { css } from "@emotion/react";
import { Button, Form, Input, InputNumber } from "antd";
import React from "react";

const { TextArea } = Input;
const OrderForm = ({
    onFinish,
    isEdit,
    onChecked,
    onChangeTotal,
    ...props
}) => {
    const [form] = Form.useForm();
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
                name="fullName"
                label="Người thanh toán"
                rules={[
                    {
                        required: true,
                        message: "Vui lòng nhập tên người thanh toán",
                    },
                ]}
            >
                <Input />
            </Form.Item>

            <Form.Item
                label="Số tiền thanh toán"
                name="total"
                rules={[
                    {
                        required: true,
                        message: "Vui lòng nhập số tiền",
                    },
                ]}
            >
                <InputNumber
                    defaultValue={
                        props.initialValues ? props.initialValues.total : ""
                    }
                /> đ
            </Form.Item>

            <Form.Item name="note" label="Ghi chú">
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

export default OrderForm;
