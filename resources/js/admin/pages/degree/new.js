import { message } from "antd";
import Breadcrumb from "../../components/breadcrumbs";
import { useNavigate } from "react-router";
import { useQueryClient } from "react-query";
import Form from "./form";

const CreateDegreePage = () => {
    const navigate = useNavigate();
    const queryClient = useQueryClient();

    const onFinish = async (values) => {
        try {
            await axios.post("/api/admin/degree", values);
            message.success("Thêm học vị thành công");
            queryClient.invalidateQueries("degree");
            navigate("/admin/degree");
        } catch ({ response }) {
            const { data } = response;
            message.error(data.message);
        }
    };

    return (
        <div>
            <Breadcrumb items={["Học vị", "Thêm mới"]} />
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
export default CreateDegreePage;
