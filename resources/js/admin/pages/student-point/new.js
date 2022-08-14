import {
    message,
} from 'antd';
import Breadcrumb from '../../components/breadcrumbs';
import { useNavigate,useParams } from 'react-router';
import { useQueryClient } from 'react-query';
import Form from './form';

const CreateStudentPointPage = () => {
    const navigate = useNavigate();
    const queryClient = useQueryClient();
    const { id , classId} = useParams();
    const onFinish = async (values) => {
        try {
            const newPoint = {...values, class_id: classId, student_id: id};
            await axios.post("/api/admin/student-point", newPoint);
            message.success("Thêm điểm thành công");
            queryClient.invalidateQueries(`/admin/class/student-detail/${id}/${classId}`);
            navigate(`/admin/class/student-detail/${id}/${classId}`);
        } catch ({ response }) {
            const { data } = response;
            message.error(data.message);
        }
    };


    return <div>
        <Breadcrumb items={["Điểm học viên", "Thêm mới"]} />
        <div className="site-layout-background" style={{ padding: 24, minHeight: 360 }}>
            <div className="d-flex justify-content-center" >
                <Form
                    studentId={id}
                    onFinish={onFinish}
                    onChecked={(value) => setStatus(value)}
                    onChangeTotal={(data) => setTotal(data)}
                />
            </div>
        </div>
    </div>
}
export default CreateStudentPointPage;
