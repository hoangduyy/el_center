import {
    message, Skeleton,
} from 'antd';
import Breadcrumb from '../../components/breadcrumbs';
import { useNavigate, useParams } from 'react-router';
import { useQueryClient, useQuery } from 'react-query';
import Form from './form';
import { useState } from "react";

const EditBlogPostPage = () => {
    const navigate = useNavigate();
    const queryClient = useQueryClient();
    const { id } = useParams();
    const [status, setStatus] = useState(true)
    const [content, setContent] = useState('')

    const { isLoading, data } = useQuery(['blog-post', [id]], async () => {
        const { data } = await axios.get("/api/admin/blog-post/" + id);
        return data;
    });

    const onFinish = async (values) => {
        try {
            values = { ...values, status: values.status, content: values.content}
            await axios.put("/api/admin/blog-post/" + id, values);
            message.success("Chỉnh sửa bài viết thành công");
            queryClient.invalidateQueries("blog-post");
            navigate("/admin/blog/post");
        } catch ({ response }) {
            const { data } = response;
            message.error(data.message);
        }
    };

    return <div>
        <Breadcrumb items={["Bài viết", "Chỉnh sửa"]} />
        <div className="site-layout-background" style={{ padding: 24, minHeight: 360 }}>
            <div className="d-flex justify-content-center" >
                <Skeleton active loading={isLoading}>
                    <Form
                        isEdit
                        initialValues={data}
                        onFinish={onFinish}
                        onChecked={(value) => setStatus(value)}
                        onEditor={(data) => setContent(data)}
                    />
                </Skeleton>
            </div>
        </div>
    </div>
}
export default EditBlogPostPage;
