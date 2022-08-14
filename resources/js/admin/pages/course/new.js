import { message } from "antd";
import Breadcrumb from "../../components/breadcrumbs";
import { useNavigate } from "react-router";
import { useQueryClient } from "react-query";
import Form from "./form";
import { useState } from "react";
import moment from "moment";

const CreateCoursePage = () => {
    const navigate = useNavigate();
    const queryClient = useQueryClient();
    const [status, setStatus] = useState(true);
    const [content, setContent] = useState("");
    const [startDate, setStartDate] = useState("")
    const [numberOfHours, setNumberOfHourse] = useState(undefined);
    const [price, setPrice] = useState(undefined);
    const [lectures, setLectures] = useState(undefined);
    const [ultilities, setUltilities] = useState(null);


    const onFinish = async (values) => {

        values = { ...values, status, content };
        values.ultilities = ultilities;
        values.rate = 5;
        values.number_of_hours = numberOfHours;
        values.price = price;
        values.lectures = lectures;
        values.start_date = moment(startDate).format(
            "YYYY/MM/DD hh:mm"
            );
        try {
            await axios.post("/api/admin/course", values);
            message.success("Thêm khoá học thành công");
            queryClient.invalidateQueries("course");
            navigate("/admin/course");
        } catch ({ response }) {
            const { data } = response;
            message.error(data.message);
        }
    };

    return (
        <div>
            <Breadcrumb items={["Khoá học", "Thêm mới"]} />
            <div
                className="site-layout-background"
                style={{ padding: 24, minHeight: 360 }}
            >
                <div className="d-flex justify-content-center">
                    <Form
                        onFinish={onFinish}
                        onChecked={(value) => setStatus(value)}
                        onEditor={(data) => setContent(data)}
                        onChangeDate={(data) => setStartDate(data)}
                        onChangeHours={(data) => setNumberOfHourse(data)}
                        onChangePrice={(data) => setPrice(data)}
                        onChangeLectures={(data) => setLectures(data)}
                        onChangeUltilities={data => setUltilities(data)}
                    />
                </div>
            </div>
        </div>
    );
};
export default CreateCoursePage;
