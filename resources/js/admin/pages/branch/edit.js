import {
    message, Skeleton,
} from 'antd';
import Breadcrumb from '../../components/breadcrumbs';
import { useNavigate, useParams } from 'react-router';
import { useQueryClient, useQuery } from 'react-query';
import Form from './form';

const EditBranchPage = () => {
    const navigate = useNavigate();
    const queryClient = useQueryClient();
    const { id } = useParams();

    const { isLoading, data } = useQuery(['branch', [id]], async () => {
        const { data } = await axios.get("/api/admin/branch/" + id);
        return data;
    });

    const onFinish = async (values) => {
        try {
            await axios.put("/api/admin/branch/" + id, values);
            message.success("Chỉnh sửa chi nhánh thành công");
            queryClient.invalidateQueries("branch");
            navigate("/admin/branch");
        } catch ({ response }) {
            const { data } = response;
            message.error(data.message);
        }
    };

    return <div>
        <Breadcrumb items={["Chi nhấnh", "Chỉnh sửa"]} />
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
export default EditBranchPage;
