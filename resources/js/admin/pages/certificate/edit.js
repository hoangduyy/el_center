import {
    message, Skeleton,
} from 'antd';
import Breadcrumb from '../../components/breadcrumbs';
import { useNavigate, useParams } from 'react-router';
import { useQueryClient, useQuery } from 'react-query';
import Form from './form';

const EditCertificatePage = () => {
    const navigate = useNavigate();
    const queryClient = useQueryClient();
    const { id } = useParams();

    const { isLoading, data } = useQuery(['certificate', [id]], async () => {
        const { data } = await axios.get("/api/admin/certificate/" + id);
        return data;
    });

    const onFinish = async (values) => {
        try {
            await axios.put("/api/admin/certificate/" + id, values);
            message.success("Chỉnh sửa Chứng chỉ thành công");
            queryClient.invalidateQueries("certificate");
            navigate("/admin/certificate");
        } catch ({ response }) {
            const { data } = response;
            message.error(data.message);
        }
    };

    return <div>
        <Breadcrumb items={["Chứng chỉ", "Chỉnh sửa"]} />
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
export default EditCertificatePage;
