import { css } from "@emotion/react";
import { Button, Form, Input, Radio, Select } from "antd";
import React, {useState } from "react";
const QuestionForm = ({ onFinish, isEdit, ...props }) => {
    const [form] = Form.useForm();
    const [value, setValue] = useState('a');
    function onChange(e) {
        setValue(e.target.value);
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
                name="question"
                label="Câu hỏi"
                rules={[
                    {
                        required: true,
                        message: "Vui lòng nhập câu hỏi",
                    },
                ]}
            >
                <Input />
            </Form.Item>
            <Form.Item
                name="da_a"
                label="Đáp án A"
                rules={[
                    {
                        required: true,
                        message: "Vui lòng nhập đáp án A",
                    },
                ]}
            >
                <Input />
            </Form.Item>

            <Form.Item
                name="da_b"
                label="Đáp án B"
                rules={[
                    {
                        required: true,
                        message: "Vui lòng nhập đáp án B",
                    },
                ]}
            >
                <Input />
            </Form.Item>

            <Form.Item
                name="da_c"
                label="Đáp án C"
                rules={[
                    {
                        required: true,
                        message: "Vui lòng nhập đáp án C",
                    },
                ]}
            >
                <Input />
            </Form.Item>

            <Form.Item
                name="da_d"
                label="Đáp án D"
                rules={[
                    {
                        required: true,
                        message: "Vui lòng nhập đáp án D",
                    },
                ]}
            >
                <Input />
            </Form.Item>

            <Form.Item label="Đáp án đúng" name="da">
                <Radio.Group onChange={onChange} value={value} defaultValue={'a'}>
                    <Radio value={'a'} checked={true}>A</Radio>
                    <Radio value={'b'}>B</Radio>
                    <Radio value={'c'}>C</Radio>
                    <Radio value={'d'}>D</Radio>
                </Radio.Group>
            </Form.Item>
            <Form.Item className="float-right">
                <Button type="primary" htmlType="submit">
                    {isEdit ? "Cập nhật" : "Thêm mới"}
                </Button>
            </Form.Item>
        </Form>
    );
};

export default QuestionForm;
