import {
    message,
} from 'antd';
import Breadcrumb from '../../components/breadcrumbs';
import { useNavigate,useParams } from 'react-router';
import { useQueryClient } from 'react-query';
import Form from './form';

const CreateOrderPage = () => {
    const navigate = useNavigate();
    const queryClient = useQueryClient();
    const {orderId} = useParams();

    const onFinish = async (values) => {
        try {
            const newOrder = {...values,order_id: orderId};
            await axios.post("/api/admin/order-history", newOrder);
            message.success("Thêm đơn thanh toán thành công");
            queryClient.invalidateQueries("blog-category");
            navigate(-1);
        } catch ({ response }) {
            const { data } = response;
            message.error(data.message);
        }
    };


    return <div>
        <Breadcrumb items={["Đơn thanh toán", "Thêm mới"]} />
        <div className="site-layout-background" style={{ padding: 24, minHeight: 360 }}>
            <div className="d-flex justify-content-center" >
                <Form
                    onFinish={onFinish}
                />
            </div>
        </div>
    </div>
}
export default CreateOrderPage;
