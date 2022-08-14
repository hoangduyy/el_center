import {
    message,
} from 'antd';
import Breadcrumb from '../../components/breadcrumbs';
import { useNavigate } from 'react-router';
import { useQueryClient } from 'react-query';
import Form from './form';
import { useState } from 'react';

const CreateOrderPage = () => {
    const navigate = useNavigate();
    const queryClient = useQueryClient();
    const [status, setStatus] = useState(true);
    const [total, setTotal] = useState(undefined);

    const onFinish = async (values) => {
        try {
            const newOrder = {...values};
            newOrder.status = status;
            newOrder.total = total;
            await axios.post("/api/admin/order", newOrder);
            message.success("Thêm đơn đăng ký thành công");
            queryClient.invalidateQueries("blog-category");
            navigate("/admin/order");
        } catch ({ response }) {
            const { data } = response;
            message.error(data.message);
        }
    };


    return <div>
        <Breadcrumb items={["Đơn đăng ký", "Thêm mới"]} />
        <div className="site-layout-background" style={{ padding: 24, minHeight: 360 }}>
            <div className="d-flex justify-content-center" >
                <Form
                    onFinish={onFinish}
                    onChecked={(value) => setStatus(value)}
                    onChangeTotal={(data) => setTotal(data)}
                />
            </div>
        </div>
    </div>
}
export default CreateOrderPage;
