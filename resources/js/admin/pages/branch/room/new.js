import {
    message,
} from 'antd';
import Breadcrumb from '../../../components/breadcrumbs';
import { useNavigate } from 'react-router';
import { useQueryClient } from 'react-query';
import Form from './form';

const CreateRoomPage = () => {
    const navigate = useNavigate();
    const queryClient = useQueryClient();

    const onFinish = async (values) => {
        try {
            await axios.post("/api/admin/room", values);
            message.success("Thêm phòng học thành công");
            queryClient.invalidateQueries("room");
            navigate("/admin/branch/room");
        } catch ({ response }) {
            const { data } = response;
            message.error(data.message);
        }
    };


    return <div>
        <Breadcrumb items={["phòng học", "Thêm mới"]} />
        <div className="site-layout-background" style={{ padding: 24, minHeight: 360 }}>
            <div className="d-flex justify-content-center" >
                <Form onFinish={onFinish}
                />
            </div>
        </div>
    </div>
}
export default CreateRoomPage;
