import { css } from "@emotion/react";
import { Button, Form, Input, Radio, Select } from "antd";
import React, { useEffect, useState } from "react";
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

    const [degrees, setDegrees] = useState([]);

    useEffect(async () => {
        await axios.get("/api/admin/degree/").then((data) => {
            setDegrees(data.data.data);
        });
    }, []);

    const [certificates, setCertificates] = useState([]);

    useEffect(async () => {
        await axios.get("/api/admin/certificate/").then((data) => {
            setCertificates(data.data.data);
        });
    }, []);


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
                label="Mã giáo viên"
                rules={[
                    {
                        required: true,
                        message: "Vui lòng nhập mã giáo viên",
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
                name="degree_id"
                label="Học vị"
                rules={[
                    {
                        required: true,
                        message: "Vui lòng chọn học vị",
                    },
                ]}
            >
                <Select
                    name="degree_id"
                    defaultValue={degrees[0]?.id}
                    showSearch
                    optionFilterProp="children"
                    filterOption={(input, option) =>
                        option.children
                            .toLowerCase()
                            .indexOf(input.toLowerCase()) >= 0
                    }
                >
                    {degrees.map((item) => (
                        <Option key={item.id} value={item.id}>
                            {item.name}
                        </Option>
                    ))}
                </Select>
            </Form.Item>
            <Form.Item
                name="certificate_id"
                label="Chứng chỉ"
                rules={[
                    {
                        required: true,
                        message: "Vui lòng chọn chứng chỉ",
                    },
                ]}
            >
                <Select
                    name="certificate_id"
                    defaultValue={certificates[0]?.id}
                    showSearch
                    optionFilterProp="children"
                    filterOption={(input, option) =>
                        option.children
                            .toLowerCase()
                            .indexOf(input.toLowerCase()) >= 0
                    }
                >
                    {certificates.map((item) => (
                        <Option key={item.id} value={item.id}>
                            {item.name}
                        </Option>
                    ))}
                </Select>
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
