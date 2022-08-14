import { css } from "@emotion/react";
import { Button, Form, Input, InputNumber, Select, Switch } from "antd";
import React, { useEffect, useState } from "react";
import { useQuery } from "react-query";

const { TextArea } = Input;
const OrderForm = ({
    onFinish,
    isEdit,
    onChecked,
    onChangeTotal,
    ...props
}) => {
    const [form] = Form.useForm();
    const [classes, setClasses] = useState();
    const [students, setStudents] = useState([])

    const { isLoading, data } = useQuery(["order"], async () => {
        const { data } = await axios.get("/api/admin/order");
        return data;
    });

    useEffect(async () => {
        const { data } = await axios.get("/api/admin/class");
        setClasses(data.data);
    }, []);

    useEffect(async () => {
        const { data } = await axios.get("/api/admin/student");
        setStudents(data.data);
    }, []);

    const handleChecked = (checked) => {
        onChecked(checked);
    };

    const handleChangeTotal = (data) => {
        onChangeTotal(data);
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
                name="fullName"
                label="Tên đầy đủ học viên"
                rules={[
                    {
                        required: true,
                        message: "Vui lòng nhập tên học viên",
                    },
                ]}
            >
                <Input />
            </Form.Item>

            <Form.Item
                name="user_id"
                label="Học viên"
                rules={[
                    {
                        required: true,
                        message: "Vui lòng chọn học viên",
                    },
                ]}
            >
                <Select
                    showSearch
                    allowClear
                    filterOption={(inputValue, option) =>
                        option.props.children
                            .toString()
                            .toLowerCase()
                            .includes(inputValue.toLowerCase())
                    }
                    defaultValue={
                        props.initialValues ? props.initialValues?.user_id : ""
                    }
                >
                    {students?.map((item, key) => (
                        <Select.Option value={item.id} key={item.id}>
                            {item.name}
                        </Select.Option>
                    ))}
                </Select>
            </Form.Item>

            <Form.Item name="note" label="Ghi chú">
                <TextArea row={6} />
            </Form.Item>

            <Form.Item
                name="phone"
                label="phone"
                rules={[
                    {
                        required: true,
                        message: "Vui lòng nhập số điện thoại",
                    },
                ]}
            >
                <Input />
            </Form.Item>

            <Form.Item
                name="email"
                label="Địa chỉ email"
                rules={[
                    {
                        required: true,
                        message: "Vui lòng nhập địa chỉ email",
                    },
                ]}
            >
                <Input type="email" />
            </Form.Item>

            <Form.Item
                label="Số tiền thanh toán"
                rules={[
                    {
                        required: true,
                        message: "Vui lòng nhập số tiền thanh toán",
                    },
                ]}
            >
                <InputNumber
                    defaultValue={
                        props.initialValues ? props.initialValues.total : ""
                    }
                    onChange={handleChangeTotal}
                />
                <span> đ</span>
            </Form.Item>

            <Form.Item
                name="class_id"
                label="Lớp học"
                rules={[
                    {
                        required: true,
                        message: "Vui lòng chọn lớp học",
                    },
                ]}
            >
                <Select
                    showSearch
                    allowClear
                    filterOption={(inputValue, option) =>
                        option.props.children
                            .toString()
                            .toLowerCase()
                            .includes(inputValue.toLowerCase())
                    }
                    defaultValue={
                        props.initialValues ? props.initialValues?.class_id : ""
                    }
                >
                    {classes?.map((item, key) => (
                        <Select.Option value={item.id} key={item.id}>
                            {item.title}
                        </Select.Option>
                    ))}
                </Select>
            </Form.Item>

            <Form.Item name="status" label="Trạng thái" valuePropName="checked">
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
    );
};

export default OrderForm;
