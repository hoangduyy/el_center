import { message } from "antd";
import Breadcrumb from "../../components/breadcrumbs";
import { useNavigate } from "react-router";
import { useQueryClient } from "react-query";
import Form from "./form";
import { useState } from "react";

const CreateBlogPostPage = () => {
    const navigate = useNavigate();
    const queryClient = useQueryClient();
    const [status, setStatus] = useState(true)
    const [content, setContent] = useState('')

    const onFinish = async (values) => {
        console.log(values ,'values');
        values = { ...values, status, content}
        try {
            await axios.post("/api/admin/blog-post", values);
            message.success("Thêm bài viết thành công");
            queryClient.invalidateQueries("blog-post");
            navigate("/admin/blog/post");
        } catch ({ response }) {
            const { data } = response;
            message.error(data.message);
        }
    };

    return (
        <div>
            <Breadcrumb items={["Bài viết", "Thêm mới"]} />
            <div
                className="site-layout-background"
                style={{ padding: 24, minHeight: 360 }}
            >
                <div className="d-flex justify-content-center">
                    <Form
                        onFinish={onFinish}
                        onChecked={(value) => setStatus(value)}
                        onEditor={(data) => setContent(data)}
                    />
                </div>
            </div>
        </div>
    );
};
export default CreateBlogPostPage;
