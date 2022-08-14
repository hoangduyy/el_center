import {
    message,
} from 'antd';
import Breadcrumb from '../../components/breadcrumbs';
import { useNavigate } from 'react-router';
import { useQueryClient } from 'react-query';
import Form from './form';

const CreateTemplatePage = () => {
    const navigate = useNavigate();
    const queryClient = useQueryClient();

    const onFinish = async (values) => {
        try {
            await axios.post("/api/admin/template", values);
            message.success("Thêm mẫu email thành công");
            queryClient.invalidateQueries("template");
            navigate("/admin/template");
        } catch ({ response }) {
            const { data } = response;
            message.error(data.message);
        }
    };


    return <div>
        <Breadcrumb items={["Mẫu Email", "Thêm mới"]} />
        <div className="site-layout-background" style={{ padding: 24, minHeight: 360 }}>
            <div className="d-flex" >
                <Form onFinish={onFinish}
                    initialValues={{
                        mailjet_id: null
                    }}
                />
            </div>
        </div>
    </div>
}
export default CreateTemplatePage;
