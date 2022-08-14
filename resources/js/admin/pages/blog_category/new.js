import {
    message,
} from 'antd';
import Breadcrumb from '../../components/breadcrumbs';
import { useNavigate } from 'react-router';
import { useQueryClient } from 'react-query';
import Form from './form';

const CreateBlogCategoryPage = () => {
    const navigate = useNavigate();
    const queryClient = useQueryClient();

    const onFinish = async (values) => {
        try {
            await axios.post("/api/admin/blog-category", values);
            message.success("Thêm tin tức thành công");
            queryClient.invalidateQueries("blog-category");
            navigate("/admin/blog/category");
        } catch ({ response }) {
            const { data } = response;
            message.error(data.message);
        }
    };


    return <div>
        <Breadcrumb items={["Tin tức", "Thêm mới"]} />
        <div className="site-layout-background" style={{ padding: 24, minHeight: 360 }}>
            <div className="d-flex justify-content-center" >
                <Form onFinish={onFinish}
                />
            </div>
        </div>
    </div>
}
export default CreateBlogCategoryPage;
