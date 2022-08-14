import {
    message, Skeleton,
} from 'antd';
import Breadcrumb from '../../components/breadcrumbs';
import { useNavigate, useParams } from 'react-router';
import { useQueryClient, useQuery } from 'react-query';
import Form from './form';
import { useState } from 'react';

const EditOrderPage = () => {
    const navigate = useNavigate();
    const queryClient = useQueryClient();
    const { id } = useParams();
    const [status, setStatus] = useState(true);
    const [total, setTotal] = useState(undefined);

    const { isLoading, data } = useQuery(['order', [id]], async () => {
        const { data } = await axios.get("/api/admin/order/" + id);
        return data;
    });

    const onFinish = async (values) => {
        try {
            const updateOrder = {...values};
            updateOrder.status = status;
            updateOrder.total = total ? total : data.total;
            await axios.put("/api/admin/order/" + id, updateOrder);
            message.success("Chỉnh sửa đơn đăng ký thành công");
            queryClient.invalidateQueries("order");
            navigate("/admin/order");
        } catch ({ response }) {
            const { data } = response;
            message.error(data.message);
        }
    };

    return <div>
        <Breadcrumb items={["Đơn đăng ký", "Chỉnh sửa"]} />
        <div className="site-layout-background" style={{ padding: 24, minHeight: 360 }}>
            <div className="d-flex justify-content-center" >
                <Skeleton active loading={isLoading}>
                    <Form
                        isEdit
                        initialValues={data}
                        onFinish={onFinish}
                        onChecked={(value) => setStatus(value)}
                        onChangeTotal={(data) => setTotal(data)}
                    />
                </Skeleton>
            </div>
        </div>
    </div>
}
export default EditOrderPage;
