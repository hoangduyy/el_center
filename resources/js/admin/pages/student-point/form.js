import { css } from "@emotion/react";
import {
    Button,
    Card,
    Descriptions,
    Form,
    Input,
    InputNumber,
    Popconfirm,
    Table,
    Typography,
} from "antd";
import axios from "axios";
import React, { useState } from "react";
import { useQuery } from "react-query";
import { useParams } from "react-router-dom";

const originData = [
    {
        key: 1,
        note: 'note',
        listen: 0,
        speak: 0,
        read: 0,
        write: 0,
    },
];

const EditableCell = ({
    editing,
    dataIndex,
    title,
    inputType,
    record,
    index,
    children,
    ...restProps
}) => {
    const inputNode = inputType === "number" ? <InputNumber /> : <Input />;
    return (
        <td {...restProps}>
            {editing ? (
                <Form.Item
                    name={dataIndex}
                    style={{
                        margin: 0,
                    }}
                    rules={[
                        {
                            required: true,
                            message: `Please Input ${title}!`,
                        },
                    ]}
                >
                    {inputNode}
                </Form.Item>
            ) : (
                children
            )}
        </td>
    );
};

const { TextArea } = Input;
const OrderForm = ({
    onFinish,
    isEdit,
    onChecked,
    onChangeTotal,
    ...props
}) => {

    const [form] = Form.useForm();
    const [points, setPoints] = useState(props.initialValues ? [props.initialValues] :  originData);
    const [editingKey, setEditingKey] = useState("");
    const { id, classId } = useParams();
    const { isLoading, data } = useQuery(["class", [id]], async () => {
        const { data } = await axios.get(
            "/api/admin/class/student-info/" + id + "/" + classId
        );
        return data;
    });

    const isEditing = (record) => record.key === editingKey;

    const edit = (record) => {
        form.setFieldsValue({
            name: "",
            age: "",
            address: "",
            ...record,
        });
        setEditingKey(record.key);
    };

    const cancel = () => {
        setEditingKey("");
    };

    const save = async (key) => {
        try {
            const row = await form.validateFields();
            const newData = [...points];
            const index = newData.findIndex((item) => key === item.key);

            if (index > -1) {
                const item = newData[index];
                newData.splice(index, 1, { ...item, ...row });
                setPoints(newData);
                setEditingKey("");
            } else {
                newData.push(row);
                setPoints(newData);
                setEditingKey("");
            }
            console.log(newData);
            onFinish(newData[0]);

        } catch (errInfo) {
            console.log("Validate Failed:", errInfo);
        }
    };

    const columns = [
        {
            title: "Ghi chú",
            dataIndex: "note",
            width: "40%",
            editable: true,
        },
        {
            title: "Nghe",
            dataIndex: "listen",
            width: "15%",
            editable: true,
        },
        {
            title: "Nói",
            dataIndex: "speak",
            width: "15%",
            editable: true,
        },
        {
            title: "Đọc",
            dataIndex: "read",
            width: "15%",
            editable: true,
        },
        {
            title: "Viết",
            dataIndex: "write",
            width: "15%",
            editable: true,
        },
        {
            title: "action",
            dataIndex: "action",
            render: (_, record) => {
                const editable = isEditing(record);
                return editable ? (
                    <span>
                        <Typography.Link
                            onClick={() => save(record.key)}
                            style={{
                                marginRight: 8,
                            }}
                        >
                            Save
                        </Typography.Link>
                        <Popconfirm title="Sure to cancel?" onConfirm={cancel}>
                            <a>Cancel</a>
                        </Popconfirm>
                    </span>
                ) : (
                    <Typography.Link
                        disabled={editingKey !== ""}
                        onClick={() => edit(record)}
                    >
                        Edit
                    </Typography.Link>
                );
            },
        },
    ];

    const mergedColumns = columns.map((col) => {
        if (!col.editable) {
            return col;
        }

        return {
            ...col,
            onCell: (record) => ({
                record,
                inputType: col.dataIndex === "age" ? "number" : "text",
                dataIndex: col.dataIndex,
                title: col.title,
                editing: isEditing(record),
            }),
        };
    });
    return (
        <div>
            {data && (
                <>
                    <Card>
                        <Descriptions title="Thông tin học lớp học">
                            <Descriptions.Item label="Tên lớp học">
                                {data.class?.title}
                            </Descriptions.Item>
                            <Descriptions.Item label="Mã lớp học">
                                {data.class?.code}
                            </Descriptions.Item>
                            <Descriptions.Item label="Phòng học">
                                {data.class.room?.name}
                            </Descriptions.Item>
                            <Descriptions.Item label="Chi nhánh">
                                {data.class?.room?.branch?.name}
                            </Descriptions.Item>
                            <Descriptions.Item label="Số  lượng">
                                {data.class?.qty}
                            </Descriptions.Item>
                            <Descriptions.Item label="Giáo viên phụ trách">
                                {data.class.teacher?.name}
                            </Descriptions.Item>
                            <Descriptions.Item label="Ngày bắt đầu">
                                {data.class?.start_date}
                            </Descriptions.Item>
                            <Descriptions.Item label="Ngày kết thúc">
                                {data.class?.end_date}
                            </Descriptions.Item>
                            <br />
                            <Descriptions.Item label="Lưu ý">
                                {data.class.note}
                            </Descriptions.Item>
                        </Descriptions>
                    </Card>
                    <Card className="mt-2">
                        <Descriptions title="Thông tin học viên">
                            <Descriptions.Item label="Tên học viên">
                                {data.student?.profile?.name}
                            </Descriptions.Item>
                            <Descriptions.Item label="Email">
                                {data.student?.email}
                            </Descriptions.Item>
                            <Descriptions.Item label="Điện thoại">
                                {data.student?.profile?.phone}
                            </Descriptions.Item>
                        </Descriptions>
                    </Card>
                </>
            )}

            <Form form={form} component={false} onFinish={onFinish}>
                <Table
                    components={{
                        body: {
                            cell: EditableCell,
                        },
                    }}
                    bordered
                    dataSource={points}
                    columns={mergedColumns}
                    rowClassName="editable-row"
                    pagination={false}
                    style={{
                        width: "100%",
                    }}
                />
            </Form>
        </div>
    );
};

export default OrderForm;
