import { message, Skeleton } from "antd";
import Breadcrumb from "../../components/breadcrumbs";
import { useNavigate, useParams } from "react-router";
import { useQueryClient, useQuery } from "react-query";
import Form from "./form";
import { useState } from "react";
import moment from "moment";

const EditBlogPostPage = () => {
    const navigate = useNavigate();
    const queryClient = useQueryClient();
    const { id } = useParams();
    const [status, setStatus] = useState(true);
    const [content, setContent] = useState("");
    const [startDate, setStartDate] = useState("");
    const [numberOfHours, setNumberOfHourse] = useState(undefined);
    const [price, setPrice] = useState(undefined);
    const [lectures, setLectures] = useState(undefined);
    const [ultilities, setUltilities] = useState(null);

    const { isLoading, data } = useQuery(["course", [id]], async () => {
        const { data } = await axios.get("/api/admin/course/" + id);
        return data;
    });

    const onFinish = async (values) => {

        try {
            const updateCourse = {
                ...values,
            };

            updateCourse.ultilities = ultilities ? ultilities : data.ultilities;;
            updateCourse.status = status;
            updateCourse.content = content ? content : data.content;
            updateCourse.price = price ? price : data.price;
            updateCourse.lectures = lectures ? lectures : data.lectures;
            updateCourse.number_of_hours = numberOfHours
                ? numberOfHours
                : data.number_of_hours;
            updateCourse.start_date = startDate
                ? moment(startDate).format("YYYY/MM/DD hh:mm")
                : data.start_date;

            await axios.put("/api/admin/course/" + id, updateCourse);
            message.success("Chỉnh sửa khoá học thành công");
            queryClient.invalidateQueries("course");
            navigate("/admin/course");
        } catch ({ response }) {
            const { data } = response;
            message.error(data.message);
        }
    };

    return (
        <div>
            <Breadcrumb items={["Khoá học", "Chỉnh sửa"]} />
            <div
                className="site-layout-background"
                style={{ padding: 24, minHeight: 360 }}
            >
                <div className="d-flex justify-content-center">
                    <Skeleton active loading={isLoading}>
                        <Form
                            isEdit
                            initialValues={data}
                            onFinish={onFinish}
                            onChecked={(value) => setStatus(value)}
                            onEditor={(data) => setContent(data)}
                            onChangeDate={(data) => setStartDate(data)}
                            onChangeHours={(data) => setNumberOfHourse(data)}
                            onChangePrice={(data) => setPrice(data)}
                            onChangeLectures={(data) => setLectures(data)}
                            onChangeUltilities={(data) => setUltilities(data)}
                        />
                    </Skeleton>
                </div>
            </div>
        </div>
    );
};
export default EditBlogPostPage;
