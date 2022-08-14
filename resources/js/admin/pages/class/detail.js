import {
    Button,
    Card,
    Descriptions,
    Input,
    Space,
    Table,
    Popconfirm,
} from "antd";
import Breadcrumb from "../../components/breadcrumbs";
import { useNavigate, useParams } from "react-router";
import { useQuery } from "react-query";
import { useState, useEffect } from "react";
import moment from "moment";
import { useDebounce } from "../../../lib/hook";
import "../../../../css/app.css";
import Calendar from "../../components/calendar";
import { Link } from "react-router-dom";
import { DeleteFilled, EditFilled } from "@ant-design/icons";
import { css } from "@emotion/react";

const DetailClassPage = () => {
    const navigate = useNavigate();
    const { id } = useParams();
    const [startDate, setStartDate] = useState("");
    const [endDate, setEndDate] = useState("");
    const [qty, setQty] = useState("");
    const [days, setDays] = useState([]);
    const [orders, setOrders] = useState([]);
    const debouncedSearchQuery = useDebounce(search, 600);
    const [isloading, setIsLoading] = useState(false);
    const [search, setSearch] = useState(null);

    const [pagination, setPagination] = useState({
        current: 1,
        pageSize: 5,
        total: 0,
    });

    const { data } = useQuery(["class", [id]], async () => {
        const { data } = await axios.get("/api/admin/class/" + id);
        const arrDays = data.schedule?.days.split(",");
        setDays(arrDays);
        return data;
    });

    useEffect(async () => {
        setIsLoading(true);
        const res = await axios.get("/api/admin/order?classId=" + id, {
            params: {
                page: pagination.current,
                pageSize: pagination.pageSize,
                search: debouncedSearchQuery,
                start_date: startDate ? startDate : null,
                end_date: endDate ? endDate : null,
            },
        });
        setPagination({
            ...pagination,
            total: res.data.total,
        });
        setOrders(res.data.data);
        setIsLoading(false);
    }, [pagination.current, debouncedSearchQuery, startDate, endDate]);

    const handleTableChange = (pagination, filters, sorter) => {
        setPagination(pagination);
    };

    return (
        <div>
            <Breadcrumb items={["Chi tiết lớp học"]}></Breadcrumb>
            {data && (
                <Card>
                    <Descriptions title="Thông tin lớp học">
                        <Descriptions.Item label="Tên lớp học">
                            {data.title}
                        </Descriptions.Item>
                        <Descriptions.Item label="Mã lớp học">
                            {data.code}
                        </Descriptions.Item>
                        <Descriptions.Item label="Phòng học">
                            {data.room?.name}
                        </Descriptions.Item>
                        <Descriptions.Item label="Chi nhánh">
                            {data.room?.branch?.name}
                        </Descriptions.Item>
                        <Descriptions.Item label="Số  lượng">
                            {data.qty}
                        </Descriptions.Item>
                        <Descriptions.Item label="Giáo viên phụ trách">
                            {data.teacher?.name}
                        </Descriptions.Item>
                        <Descriptions.Item label="Ngày bắt đầu">
                            {data.start_date}
                        </Descriptions.Item>
                        <Descriptions.Item label="Ngày kết thúc">
                            {data.end_date}
                        </Descriptions.Item>
                        <br />
                        {days && (
                            <Descriptions.Item label="Lịch học">
                                <div style={{ display: "block" }}>
                                    {days.map((item) => {
                                        return (
                                            <span key={item}>Thứ {item}, </span>
                                        );
                                    })}{" "}
                                    <br />
                                    <div>
                                        Từ {data.schedule?.start_hour} - đến{" "}
                                        {data.schedule?.end_hour}
                                    </div>
                                </div>
                            </Descriptions.Item>
                        )}
                        <Descriptions.Item label="Lưu ý">
                            {data.note}
                        </Descriptions.Item>
                    </Descriptions>
                </Card>
            )}

            <div>
                {orders && (
                    <Card className="mt-2">
                        <Breadcrumb items={["Đơn đăng ký"]}>
                            <Space>
                                <Button
                                    onClick={() => navigate("/admin/order/new")}
                                    className="ml-auto"
                                    type="primary"
                                >
                                    Thêm đơn đăng ký
                                </Button>
                                <Input
                                    placeholder="Tìm kiếm"
                                    value={search}
                                    onChange={(e) => setSearch(e.target.value)}
                                />
                                <Calendar
                                    name="startDate"
                                    onChange={(date) => setStartDate(date)}
                                    placeholder="Start date"
                                />
                                <Calendar
                                    name="endDate"
                                    onChange={(date) => setEndDate(date)}
                                    placeholder="End date"
                                />
                            </Space>
                        </Breadcrumb>
                        <Table
                            footer={() =>
                                `Tổng số đơn đăng ký ${pagination.total}`
                            }
                            rowKey={(record) => record.id}
                            pagination={pagination}
                            onChange={handleTableChange}
                            columns={[
                                {
                                    title: "STT",
                                    render: (text, record, index) => index + 1,
                                },
                                {
                                    title: "Tên học viên",
                                    render: (text, record) => (
                                        <Link
                                            to={`/admin/class/student-detail/${record.user_id}/${id}`}
                                        >
                                            {record.fullName}
                                        </Link>
                                    ),
                                },
                                {
                                    title: "Số điện thoại",
                                    dataIndex: "phone",
                                },
                                {
                                    title: "Địa chỉ email",
                                    dataIndex: "email",
                                },
                                {
                                    title: "Ghi chú",
                                    dataIndex: "note",
                                },
                                {
                                    title: "Giá tiền",
                                    dataIndex: "total",
                                },
                                {
                                    title: "Ngày đăng ký",
                                    render: (text, record, index) => {
                                        return (
                                            <span>
                                                {moment(
                                                    record.created_at
                                                ).format("DD/MM/YYYY, hh:mm")}
                                            </span>
                                        );
                                    },
                                },
                                {
                                    width: 100,
                                    render: (text, record, index) => {
                                        return (
                                            <div key={index}>
                                                <Link
                                                    className="mr-2"
                                                    to={`/admin/order/${record.id}`}
                                                >
                                                    <EditFilled />
                                                </Link>
                                                <Popconfirm
                                                    title="Xác nhận xoá"
                                                    onConfirm={() =>
                                                        handleDelete(record.id)
                                                    }
                                                >
                                                    <DeleteFilled
                                                        css={css`
                                                            color: red;
                                                        `}
                                                    />
                                                </Popconfirm>
                                            </div>
                                        );
                                    },
                                },
                            ]}
                            dataSource={orders}
                            loading={isloading}
                        />
                    </Card>
                )}
            </div>
        </div>
    );
};
export default DetailClassPage;
