import { Card, message, Table } from "antd";
import Breadcrumb from "../../components/breadcrumbs";
import { useNavigate } from "react-router";
import { useQueryClient } from "react-query";
import Form from "./form";
import { useState } from "react";
import {
    CheckCircleOutlined,
} from "@ant-design/icons";



const CreateClassSchedulePage = () => {
    const queryClient = useQueryClient();
    const [success, setSuccess] = useState(false);
    const [days, setDays] = useState([]);

    const onFinish = async (values) => {    
        try {
            setDays(
                [values.days.reduce((a, v) => ({ ...a, [v]: <CheckCircleOutlined style={{color: "green"}}/> }), {})]
            );
            await axios.post("/api/admin/class-schedule", values);
            message.success("Thêm thời khoá biểu thành công");
            queryClient.invalidateQueries("class-schedule");
            setSuccess(true);
        } catch ({ response }) {
            const { data } = response;
            message.error(data.message);
        }
    };

    const columns = [
        {
            title: "Thứ 2",
            dataIndex: "2",
            key: "2",
        },
        {
            title: "Thứ 3",
            dataIndex: "3",
            key: "3",
        },
        {
            title: "Thứ 4",
            dataIndex: "4",
            key: "4",
        },
        {
            title: "Thứ 5",
            dataIndex: "5",
            key: "5",
        },
        {
            title: "Thứ 6",
            dataIndex: "6",
            key: "6",
        },
        {
            title: "Thứ 7",
            dataIndex: "7",
            key: "7",
        },
        {
            title: "Chủ nhật",
            dataIndex: "8",
            key: "8",
        },
    ];

    return (
        <div>
            <Breadcrumb items={["Thời khoá biểu", "Thêm mới"]} />
            <div
                className="site-layout-background"
                style={{ padding: 24, minHeight: 360 }}
            >
                <div className="d-flex justify-content-center">
                    <Card bordered={true} style={{ width: 900 }}>
                        <Form
                            onFinish={onFinish}
                            success={success}
                        />
                        {
                            success && (
                                <Table dataSource={days} columns={columns} pagination={false} />
                            )
                        }
                    </Card>
                </div>
            </div>
        </div>
    );
};
export default CreateClassSchedulePage;
