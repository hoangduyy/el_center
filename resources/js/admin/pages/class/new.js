import { message } from "antd";
import Breadcrumb from "../../components/breadcrumbs";
import { useNavigate } from "react-router";
import { useQueryClient } from "react-query";
import Form from "./form";
import { useState } from "react";
import moment from "moment";

const CreateClassPage = () => {
    const navigate = useNavigate();
    const queryClient = useQueryClient();
    const [status, setStatus] = useState(true);
    const [starDate, setStartDate] = useState("")
    const [endDate, setEndDate] = useState("")
    const [qty, setQty] = useState("");

    const onFinish = async (values) => {
        values = { ...values, status };
        values.start_date = moment(starDate).format(
            "YYYY/MM/DD hh:mm"
        );
        values.end_date = moment(endDate).format("YYYY/MM/DD hh:mm");
        values.qty = qty;
        try {
            await axios.post("/api/admin/class", values);
            message.success("Thêm lớp học thành công");
            queryClient.invalidateQueries("class");
            navigate("/admin/class");
        } catch ({ response }) {
            const { data } = response;
            message.error(data.message);
        }
    };

    return (
        <div>
            <Breadcrumb items={["Tin tức", "Thêm mới"]} />
            <div
                className="site-layout-background"
                style={{ padding: 24, minHeight: 360 }}
            >
                <div className="d-flex justify-content-center">
                    <Form
                        onFinish={onFinish}
                        onChecked={(value) => setStatus(value)}
                        onChangeQty={(data) => setQty(data)}
                        onChangeStartDate={(data) => setStartDate(data)}
                        onChangeEndDate={(data) => setEndDate(data)}
                    />
                </div>
            </div>
        </div>
    );
};
export default CreateClassPage;
