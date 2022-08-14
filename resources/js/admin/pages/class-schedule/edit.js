import {
    Card,
    message, Skeleton,
} from 'antd';
import Breadcrumb from '../../components/breadcrumbs';
import { useNavigate, useParams } from 'react-router';
import { useQueryClient, useQuery } from 'react-query';
import Form from './form';
import { useState } from 'react';

const EditClassSchedulePage = () => {
    const navigate = useNavigate();
    const queryClient = useQueryClient();
    const { id } = useParams();
    const [success, setSuccess] = useState(false);
    const [days, setDays] = useState([]);

    const { isLoading, data } = useQuery(['class-schedule', [id]], async () => {
        const { data } = await axios.get("/api/admin/class-schedule/" + id);
        return data;
    });

    const onFinish = async (values) => {
        try {
            await axios.put("/api/admin/class-schedule/" + id, values);
            message.success("Chỉnh sửa thời khoá biểu thành công");
            queryClient.invalidateQueries("class-schedule");
            navigate("/admin/blog/category");
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


    return <div>
        <Breadcrumb items={["Thời khoá biểu", "Cập nhật"]} />
        <div className="site-layout-background" style={{ padding: 24, minHeight: 360 }}>
            <div className="d-flex justify-content-center" >
                <Skeleton active loading={isLoading}>
                     <Card bordered={true} style={{ width: 900 }}>
                        <Form
                             isEdit
                             initialValues={data}
                             onFinish={onFinish}
                        />
                        {
                            success && (
                                <Table dataSource={days} columns={columns} pagination={false} />
                            )
                        }
                    </Card>
                </Skeleton>
            </div>
        </div>
    </div>
}
export default EditClassSchedulePage;
