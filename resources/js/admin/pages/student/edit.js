import { message, Skeleton } from "antd";
import Breadcrumb from "../../components/breadcrumbs";
import { useNavigate, useParams } from "react-router";
import { useQueryClient, useQuery } from "react-query";
import Form from "./form";

const EditStudentPage = () => {
    const navigate = useNavigate();
    const queryClient = useQueryClient();
    const { id } = useParams();

    const { isLoading, data } = useQuery(["student", [id]], async () => {
        const { data } = await axios.get("/api/admin/student/" + id);
        return { ...data.profile, email: data.email, fullName: data.name };
    });


    const onFinish = async (values) => {
        try {
            values = { ...values };
            await axios.put("/api/admin/student/" + id, values);
            message.success("Sữa học viên thành công");
            queryClient.invalidateQueries("student");
            navigate("/admin/student");
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
            <Breadcrumb items={["Học viên", "Chỉnh sửa"]} />
            <div
                className="site-layout-background"
                style={{ padding: 24, minHeight: 360 }}
            >
                <div className="d-flex justify-content-center">
                    <Skeleton active loading={isLoading}>
                        <Form isEdit initialValues={data} onFinish={onFinish} />
                    </Skeleton>
                </div>
            </div>
        </div>
    );
};
export default EditStudentPage;
