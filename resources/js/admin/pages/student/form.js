import { css } from "@emotion/react";
import { Button, Form, Input, Radio } from "antd";
import React, { useState } from "react";
import { useQuery } from "react-query";
import moment from "moment";
import Calendar from "../../components/calendar";
const StudentForm = ({ onFinish, isEdit, ...props }) => {
    const [form] = Form.useForm();
    const { isLoading, data } = useQuery(["student"], async () => {
        const { data } = await axios.get("/api/admin/student");
        return data;
    });
    const [value, setValue] = useState(0);
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
                name="name"
                label="Mã học viên"
                rules={[
                    {
                        required: true,
                        message: "Vui lòng nhập tài khoản",
                    },
                ]}
            >
                <Input />
            </Form.Item>
            <Form.Item
                name="email"
                label="Email"
                rules={[
                    {
                        required: true,
                        message: "Vui lòng nhập email",
                    },
                ]}
            >
                <Input />
            </Form.Item>
            <Form.Item
                name="fullName"
                label="Họ và tên"
                rules={[
                    {
                        required: true,
                        message: "Vui lòng nhập họ và tên",
                    },
                ]}
            >
                <Input />
            </Form.Item>
            <Form.Item
                name="address"
                label="Địa chỉ"
                rules={[
                    {
                        required: true,
                        message: "Vui lòng nhập địa chỉ",
                    },
                ]}
            >
                <Input />
            </Form.Item>
            <Form.Item
                name="birthday"
                label="Ngày sinh"
                rules={[
                    {
                        required: true,
                        message: "Vui lòng nhập địa chỉ",
                    },
                ]}
            >
                <Calendar
                    autoFocus
                    name="birthday"
                    defaultValue={
                        props.initialValues
                            ? moment(
                                  new Date(props.initialValues.birthday),
                                  "DD/MM/YYYY"
                              )
                            : ""
                    }
                    onChange={(value) => moment(value).format("YYYY-MM-DD")}
                />
            </Form.Item>
            <Form.Item label="Giới tính" name="gender">
                <Radio.Group onChange={onChange} value={value}>
                    <Radio value={0}>Nam</Radio>
                    <Radio value={1}>Nữ</Radio>
                </Radio.Group>
            </Form.Item>
            <Form.Item
                name="phone"
                label="Số điện thoại"
                rules={[
                    {
                        required: true,
                        message: "Vui lòng nhập số điện thoại",
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

export default StudentForm;
