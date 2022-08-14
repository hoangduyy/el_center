import {
    message,
} from 'antd';
import Breadcrumb from '../../components/breadcrumbs';
import { useNavigate } from 'react-router';
import { useQueryClient } from 'react-query';
import Form from './form';

const CreateCampaignPage = () => {
    const navigate = useNavigate();
    const queryClient = useQueryClient();

    const onFinish = async (values) => {
        console.log(values)
        try {
            await axios.post("/api/admin/campaign", values);
            message.success("Thêm chiến dịch thành công");
            queryClient.invalidateQueries("campaign");
            navigate("/admin/campaign");
        } catch ({ response }) {
            const { data } = response;
            message.error(data.message);
        }
    };


    return <div>
        <Breadcrumb items={["Chiến dịch", "Thêm mới"]} />
        <div className="site-layout-background" style={{ padding: 24, minHeight: 360 }}>
            <div className="d-flex justify-content-center" >
                <Form onFinish={onFinish}
                />
            </div>
        </div>
    </div>
}
export default CreateCampaignPage;
