import { Button, Card, Descriptions, Input, Space, Table } from "antd";
import Breadcrumb from "../../components/breadcrumbs";
import { useNavigate, useParams } from "react-router";
import { useQuery } from "react-query";
import { useState, useEffect } from "react";
import moment from "moment";
import { useDebounce } from "../../../lib/hook";
import "../../../../css/app.css";
import Calendar from "../../components/calendar";
import { Link } from "react-router-dom";
import {
    EditFilled,
    FileExcelOutlined,
    FilePdfOutlined,
} from "@ant-design/icons";

const DetailStudentPage = () => {
    const navigate = useNavigate();
    const { id, classId } = useParams();

    const [startDate, setStartDate] = useState("");
    const [endDate, setEndDate] = useState("");

    const [days, setDays] = useState([]);
    const [orders, setOrders] = useState([]);
    const [points, setPoints] = useState([]);
    const debouncedSearchQuery = useDebounce(search, 600);
    const [isloading, setIsLoading] = useState(false);

    const [search, setSearch] = useState(null);
    const [searchOrder, setSearchOrder] = useState(null);

    const [paginationPoint, setPaginationPoint] = useState({
        current: 1,
        pageSize: 5,
        total: 0,
    });

    const [paginationOrder, setPaginationOrder] = useState({
        current: 1,
        pageSize: 5,
        total: 0,
    });

    const { isLoading, data } = useQuery(["class", [id]], async () => {
        const { data } = await axios.get(
            "/api/admin/class/student-info/" + id + "/" + classId
        );
        const arrDays = data.class.schedule?.days.split(",");
        setDays(arrDays);
        return data;
    });

    useEffect(async () => {
        setIsLoading(true);
        const res = await axios.get(
            "/api/admin/student-point?class_id=" + classId,
            {
                params: {
                    page: paginationPoint.current,
                    pageSize: paginationPoint.pageSize,
                    search: searchOrder,
                    start_date: startDate ? startDate : null,
                    end_date: endDate ? endDate : null,
                },
            }
        );
        setPaginationPoint({
            ...paginationPoint,
            total: res.data.total,
        });

        setPoints(res.data.data);
        setIsLoading(false);
    }, [paginationPoint.current, searchOrder, startDate, endDate]);

    useEffect(async () => {
        setIsLoading(true);
        if (!data?.order) return;
        const res = await axios.get(
            "/api/admin/order-history?order_id=" + data.order?.id,
            {
                params: {
                    page: paginationOrder.current,
                    pageSize: paginationOrder.pageSize,
                    search: debouncedSearchQuery,
                    start_date: startDate ? startDate : null,
                    end_date: endDate ? endDate : null,
                },
            }
        );
        setPaginationOrder({
            ...paginationOrder,
            total: res.data.total,
        });
        setOrders(res.data.data);
        setIsLoading(false);
    }, [
        paginationOrder.current,
        debouncedSearchQuery,
        startDate,
        endDate,
        data,
    ]);

    const handleTablePointChange = (pagination, filters, sorter) => {
        paginationPoint(pagination);
    };

    const handleTableOrderChange = (pagination, filters, sorter) => {
        setPaginationOrder(pagination);
    };
    return (
        <div>
            <Breadcrumb items={["Chi tiết học sinh"]}></Breadcrumb>
            {data && (
                <div>
                    <Card>
                        <Descriptions title="Thông tin học lớp học">
                            <Descriptions.Item label="Tên lớp học">
                                {data.class?.title}
                            </Descriptions.Item>
                            <Descriptions.Item label="Mã lớp học">
                                {data.class?.code}
                            </Descriptions.Item>
                            <Descriptions.Item label="Phòng học">
                                {data.class.room?.name}
                            </Descriptions.Item>
                            <Descriptions.Item label="Chi nhánh">
                                {data.class?.room?.branch?.name}
                            </Descriptions.Item>
                            <Descriptions.Item label="Số  lượng">
                                {data.class?.qty}
                            </Descriptions.Item>
                            <Descriptions.Item label="Giáo viên phụ trách">
                                {data.class.teacher?.name}
                            </Descriptions.Item>
                            <Descriptions.Item label="Ngày bắt đầu">
                                {data.class?.start_date}
                            </Descriptions.Item>
                            <Descriptions.Item label="Ngày kết thúc">
                                {data.class?.end_date}
                            </Descriptions.Item>
                            <br />
                            {days && (
                                <Descriptions.Item label="Lịch học">
                                    <div style={{ display: "block" }}>
                                        {days.map((item) => {
                                            return (
                                                <span key={item}>
                                                    Thứ {item},{" "}
                                                </span>
                                            );
                                        })}{" "}
                                        <br />
                                        <div>
                                            Từ {data.class.schedule?.start_hour}{" "}
                                            - đến{" "}
                                            {data.class.schedule?.end_hour}
                                        </div>
                                    </div>
                                </Descriptions.Item>
                            )}
                            <Descriptions.Item label="Lưu ý">
                                {data.class.note}
                            </Descriptions.Item>
                        </Descriptions>
                    </Card>
                    <Card className="mt-2">
                        <Descriptions title="Thông tin học viên">
                            <Descriptions.Item label="Tên học viên">
                                {data.student?.profile?.name}
                            </Descriptions.Item>
                            <Descriptions.Item label="Email">
                                {data.student?.email}
                            </Descriptions.Item>
                            <Descriptions.Item label="Điện thoại">
                                {data.student?.profile?.phone}
                            </Descriptions.Item>
                        </Descriptions>
                    </Card>
                    <Card className="mt-2">
                        <Descriptions title="Học phí">
                            <Descriptions.Item label="Tổng học phí">
                                {data.order?.total?.toLocaleString()} đ
                            </Descriptions.Item>
                            <Descriptions.Item label="Đã thanh toán">
                                {data.student?.email}
                            </Descriptions.Item>
                            <br />
                            <Descriptions.Item label="Ghi chú">
                                {data.order?.note}
                            </Descriptions.Item>
                        </Descriptions>
                    </Card>
                </div>
            )}
            <div>
                <Card className="mt-2">
                    <Breadcrumb items={["Điểm học viên"]}>
                        <Space>
                            <Button
                                onClick={() =>
                                    navigate(
                                        "/admin/student-point/new/" +
                                            data.student?.id +
                                            "/" +
                                            data.class?.id
                                    )
                                }
                                className="ml-auto"
                                type="primary"
                            >
                                Thêm mới
                            </Button>
                            <Input
                                placeholder="Tìm kiếm"
                                value={searchOrder}
                                onChange={(e) => setSearchOrder(e.target.value)}
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
                        footer={() => `Tổng số điểm ${paginationPoint.total}`}
                        rowKey={(record) => record.id}
                        pagination={paginationPoint}
                        onChange={handleTablePointChange}
                        columns={[
                            {
                                title: "STT",
                                render: (text, record, index) => index + 1,
                            },
                            {
                                title: "Điểm nghe",
                                dataIndex: "listen",
                            },
                            {
                                title: "Điểm nói",
                                dataIndex: "speak",
                            },
                            {
                                title: "Điểm đọc",
                                dataIndex: "read",
                            },
                            {
                                title: "Điểm viết",
                                dataIndex: "write",
                            },
                            {
                                title: "Ghi chú",
                                dataIndex: "note",
                            },
                            {
                                title: "Ngày tạo",
                                render: (text, record, index) => {
                                    return (
                                        <span>
                                            {moment(record.created_at).format(
                                                "DD/MM/YYYY, hh:mm"
                                            )}
                                        </span>
                                    );
                                },
                            },
                            {
                                title: "Ngày cập nhật",
                                render: (text, record, index) => {
                                    return (
                                        <span>
                                            {moment(record.updated_at).format(
                                                "DD/MM/YYYY, hh:mm"
                                            )}
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
                                                to={`/admin/student-point/${data.student?.id}/${data.class?.id}/${record.id}`}
                                            >
                                                <EditFilled />
                                            </Link>
                                        </div>
                                    );
                                },
                            },
                        ]}
                        dataSource={points}
                        loading={isloading}
                    />
                </Card>
            </div>
            <div>
                {orders && (
                    <Card className="mt-2">
                        <Breadcrumb items={["Lịch sử thanh toán"]}>
                            <Space>
                                <Button
                                    onClick={() => {
                                        window.location.href =
                                            "/api/admin/order/export-pdf/" +
                                            data.order?.id;
                                    }}
                                    className="ml-auto"
                                    type="primary"
                                >
                                    <FilePdfOutlined />
                                </Button>
                                <Button
                                    onClick={() => {
                                        window.location.href =
                                            "/api/admin/order/export/" +
                                            data.order?.id;
                                    }}
                                    className="ml-auto bg-success"
                                    type="primary"
                                >
                                    <FileExcelOutlined />
                                </Button>

                                <Button
                                    onClick={() =>
                                        navigate(
                                            `/admin/order-history/new/${data.order?.id}`
                                        )
                                    }
                                    className="ml-auto"
                                    type="primary"
                                >
                                    Thêm mới
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
                                `Tổng số đơn đăng ký ${paginationOrder.total}`
                            }
                            rowKey={(record) => record.id}
                            pagination={paginationOrder}
                            onChange={handleTableOrderChange}
                            columns={[
                                {
                                    title: "STT",
                                    render: (text, record, index) => index + 1,
                                },
                                {
                                    title: "Người nạp",
                                    dataIndex: "fullName",
                                },
                                {
                                    title: "Người thu",
                                    render: (text, record, index) => {
                                        return (
                                            <span>{record.creator.email}</span>
                                        );
                                    },
                                },
                                {
                                    title: "Số tiền",
                                    render: (text, record, index) => {
                                        return (
                                            <span>
                                                {record.total.toLocaleString()}{" "}
                                                đ
                                            </span>
                                        );
                                    },
                                },
                                {
                                    title: "Ghi chú",
                                    dataIndex: "note",
                                },
                                {
                                    title: "Ngày nạp",
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
                                    title: "Ngày cập nhật",
                                    render: (text, record, index) => {
                                        return (
                                            <span>
                                                {moment(
                                                    record.updated_at
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
                                                    to={`/admin/order-history/${record.id}`}
                                                >
                                                    <EditFilled />
                                                </Link>
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
export default DetailStudentPage;
