import {
    message, Skeleton,
} from 'antd';
import Breadcrumb from '../../components/breadcrumbs';
import { useNavigate, useParams } from 'react-router';
import { useQueryClient, useQuery } from 'react-query';
import Form from './form';

const CreateCampaignPage = () => {
    const navigate = useNavigate();
    const queryClient = useQueryClient();
    const { id } = useParams();

    const { isLoading, data } = useQuery(['campaign', [id]], async () => {
        const { data } = await axios.get("/api/admin/campaign/" + id);
        return data;
    });

    const onFinish = async (values) => {
        console.log(values)
        try {
            await axios.put("/api/admin/campaign/" + id, values);
            message.success("Chỉnh sửa chiến dịch thành công");
            queryClient.invalidateQueries("campaign");
            navigate("/admin/campaign");
        } catch ({ response }) {
            const { data } = response;
            message.error(data.message);
        }
    };

    return <div>
        <Breadcrumb items={["Chiến dịch", "Chỉnh sửa"]} />
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
export default CreateCampaignPage;
