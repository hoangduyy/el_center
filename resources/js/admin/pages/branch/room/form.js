import { css } from "@emotion/react";
import { Button, Form, Input, Select } from "antd";
import React, { useEffect, useState } from "react";
import { useQuery } from "react-query";

const { TextArea } = Input;
const RoomForm = ({ onFinish, isEdit, ...props }) => {
    const [form] = Form.useForm();
    const [branches, setBranches] = useState([])

    const { isLoading, data } = useQuery(["room"], async () => {
        const { data } = await axios.get("/api/admin/room");
        return data;
    });

    useEffect(async () => {
        const { data } = await axios.get("/api/admin/branch");
        setBranches(data.data);
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
                label="Tên phòng học"
                rules={[
                    {
                        required: true,
                        message: "Vui lòng nhập phòng học",
                    },
                ]}
            >
                <Input />
            </Form.Item>
            <Form.Item name="description" label="Mô tả">
                <TextArea row={6} />
            </Form.Item>

            <Form.Item name="branch_id" label="Chi nhánh">
                <Select>
                    {branches.map((item, key) => (
                        <Select.Option value={item.id} key={item.id}>
                            {item.name}
                        </Select.Option>
                    ))}
                </Select>
            </Form.Item>

            <Form.Item className="float-right">
                <Button type="primary" htmlType="submit">
                    {isEdit ? "Cập nhật" : "Thêm mới"}
                </Button>
            </Form.Item>
        </Form>
    );
};

export default RoomForm;
