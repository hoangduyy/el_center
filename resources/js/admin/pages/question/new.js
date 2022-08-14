import { message } from "antd";
import Breadcrumb from "../../components/breadcrumbs";
import { useNavigate } from "react-router";
import { useQueryClient } from "react-query";
import Form from "./form";

const CreateQuestionPage = () => {
    const navigate = useNavigate();
    const queryClient = useQueryClient();

    const onFinish = async (values) => {
        values = { ...values}
        console.log(values, '//values')
        try {
            await axios.post("/api/admin/question", values);
            message.success("Thêm câu hỏi thành công");
            navigate("/admin/question");
        } catch ({ response }) {
            const { data } = response;
            const { error } = data;
            let errorMessage = "Error";

            for (const [key, value] of Object.entries(error)) {
                errorMessage = value;
            }
            message.error(errorMessage);
        }
    };

    return (
        <div>
            <Breadcrumb items={["Bộ câu hỏi", "Thêm mới"]} />
            <div
                className="site-layout-background"
                style={{ padding: 24, minHeight: 360 }}
            >
                <div className="d-flex justify-content-center">
                    <Form onFinish={onFinish}/>
                </div>
            </div>
        </div>
    );
};
export default CreateQuestionPage;
