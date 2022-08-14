import { message } from "antd";
import Breadcrumb from "../../../components/breadcrumbs";
import { useNavigate } from "react-router";
import { useQueryClient } from "react-query";
import Form from "./form";

const CreateLevelPage = () => {
    const navigate = useNavigate();
    const queryClient = useQueryClient();

    const onFinish = async (values) => {
        try {
            await axios.post("/api/admin/level", values);
            message.success("Thêm trình độ thành công");
            queryClient.invalidateQueries("level");
            navigate("/admin/course/level");
        } catch ({ response }) {
            const { data } = response;
            message.error(data.message);
        }
    };

    return (
        <div>
            <Breadcrumb items={["Trình độ", "Thêm mới"]} />
            <div
                className="site-layout-background"
                style={{ padding: 24, minHeight: 360 }}
            >
                <div className="d-flex justify-content-center">
                    <Form onFinish={onFinish} />
                </div>
            </div>
        </div>
    );
};
export default CreateLevelPage;
