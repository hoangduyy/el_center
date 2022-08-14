import {
    message, Skeleton,
} from 'antd';
import Breadcrumb from '../../components/breadcrumbs';
import { useNavigate, useParams } from 'react-router';
import { useQueryClient, useQuery } from 'react-query';
import Form from './form';
import { useState } from 'react';
import moment from 'moment';

const EditClassPage = () => {
    const navigate = useNavigate();
    const queryClient = useQueryClient();
    const { id } = useParams();
    const [starDate, setStartDate] = useState("")
    const [endDate, setEndDate] = useState("")
    const [qty, setQty] = useState("");

    const { isLoading, data } = useQuery(['class', [id]], async () => {
        const { data } = await axios.get("/api/admin/class/" + id);
        return data;
    });

    const onFinish = async (values) => {
        try {
            const updateClass = {
                ...values,
            };
            console.log(data,'dat')
            updateClass.start_date = starDate
                ? moment(starDate).format("YYYY/MM/DD hh:mm")
                : data.start_date;
            updateClass.end_date = endDate
                ? moment(endDate).format("YYYY/MM/DD hh:mm")
                : data.end_date;
            updateClass.qty = qty ? qty : data.qty;
            console.log(updateClass, 'class')
            await axios.put("/api/admin/class/" + id, updateClass);
            message.success("Chỉnh sửa tin tức thành công");
            queryClient.invalidateQueries("class");
            navigate("/admin/class");
        } catch (error) {
            // const { data } = response;
            message.error(error);
        }
    };

    return <div>
        <Breadcrumb items={["Tin tức", "Chỉnh sửa"]} />
        <div className="site-layout-background" style={{ padding: 24, minHeight: 360 }}>
            <div className="d-flex justify-content-center" >
                <Skeleton active loading={isLoading}>
                    <Form
                        isEdit
                        initialValues={data}
                        onFinish={onFinish}
                        onChangeQty={(data) => setQty(data)}
                        onChangeStartDate={(data) => setStartDate(data)}
                        onChangeEndDate={(data) => setEndDate(data)}
                    />
                </Skeleton>
            </div>
        </div>
    </div>
}
export default EditClassPage;
