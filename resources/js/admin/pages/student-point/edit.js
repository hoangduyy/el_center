import {
    message, Skeleton,
} from 'antd';
import Breadcrumb from '../../components/breadcrumbs';
import { useNavigate, useParams } from 'react-router';
import { useQueryClient, useQuery } from 'react-query';
import Form from './form';

const UpdateStudentPointPage = () => {
    const navigate = useNavigate();
    const queryClient = useQueryClient();
    const { id , classId, pointId} = useParams();

    const { isLoading, data } = useQuery(['student-point', [id]], async () => {
        const { data } = await axios.get("/api/admin/student-point/" + pointId);
        return data;
    });

    const onFinish = async (values) => {
        try {
            await axios.put("/api/admin/student-point/" + pointId, values);
            message.success("Chỉnh sửa điểm thành công");
            queryClient.invalidateQueries("student-point");
            navigate(`/admin/class/student-detail/${id}/${classId}`);
        } catch ({ response }) {
            const { data } = response;
            message.error(data.message);
        }
    };

    return <div>
   <Breadcrumb items={["Điểm học viên", "Chỉnh sửa"]} />
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
export default UpdateStudentPointPage;
