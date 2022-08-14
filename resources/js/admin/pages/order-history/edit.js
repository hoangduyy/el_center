import {
    message, Skeleton,
} from 'antd';
import Breadcrumb from '../../components/breadcrumbs';
import { useNavigate, useParams } from 'react-router';
import { useQueryClient, useQuery } from 'react-query';
import Form from './form';

const EditOrderPage = () => {
    const navigate = useNavigate();
    const queryClient = useQueryClient();
    const { id } = useParams();

    const { isLoading, data } = useQuery(['order', [id]], async () => {
        const { data } = await axios.get("/api/admin/order-history/" + id);
        return data;
    });

    const onFinish = async (values) => {
        try {
            const updateOrder = {...values};
            await axios.put("/api/admin/order-history/" + id, updateOrder);
            message.success("Chỉnh sửa đơn thanh toán thành công");
            queryClient.invalidateQueries("order");
            navigate(-1);
        } catch ({ response }) {
            const { data } = response;
            message.error(data.message);
        }
    };

    return <div>
        <Breadcrumb items={["Đơn thanh toán", "Chỉnh sửa"]} />
        <div className="site-layout-background" style={{ padding: 24, minHeight: 360 }}>
            <div className="d-flex justify-content-center" >
                <Skeleton active loading={isLoading}>
                    <Form
                        isEdit
                        initialValues={data}
                        onFinish={onFinish}
                    />
                </Skeleton>
            </div>
        </div>
    </div>
}
export default EditOrderPage;
