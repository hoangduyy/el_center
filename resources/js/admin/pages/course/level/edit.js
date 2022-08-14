import {
    message, Skeleton,
} from 'antd';
import Breadcrumb from '../../../components/breadcrumbs';
import { useNavigate, useParams } from 'react-router';
import { useQueryClient, useQuery } from 'react-query';
import Form from './form';

const UpdateLevelPage = () => {
    const navigate = useNavigate();
    const queryClient = useQueryClient();
    const { id } = useParams();

    const { isLoading, data } = useQuery(['level', [id]], async () => {
        const { data } = await axios.get("/api/admin/level/" + id);
        return data;
    });

    const onFinish = async (values) => {
        try {
            await axios.put("/api/admin/level/" + id, values);
            message.success("Chỉnh sử trình độ thành công");
            queryClient.invalidateQueries("level");
            navigate("/admin/course/level");
        } catch ({ response }) {
            const { data } = response;
            message.error(data.message);
        }
    };

    return <div>
        <Breadcrumb items={["Level", "Chỉnh sửa"]} />
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
export default UpdateLevelPage;
