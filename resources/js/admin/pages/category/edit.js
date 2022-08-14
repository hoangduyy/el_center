import {
    message, Skeleton,
} from 'antd';
import Breadcrumb from '../../components/breadcrumbs';
import { useNavigate, useParams } from 'react-router';
import { useQueryClient, useQuery } from 'react-query';
import Form from './form';

const UpdateCategoryPage = () => {
    const navigate = useNavigate();
    const queryClient = useQueryClient();
    const { id } = useParams();

    const { isLoading, data } = useQuery(['category', [id]], async () => {
        const { data } = await axios.get("/api/admin/category/" + id);
        return data;
    });

    const onFinish = async (values) => {
        try {
            await axios.put("/api/admin/category/" + id, values);
            message.success("Chỉnh sửa danh mục thành công");
            queryClient.invalidateQueries("category");
            navigate("/admin/category");
        } catch ({ response }) {
            const { data } = response;
            message.error(data.message);
        }
    };

    return <div>
        <Breadcrumb items={["Danh mục", "Chỉnh sửa"]} />
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
export default UpdateCategoryPage;
