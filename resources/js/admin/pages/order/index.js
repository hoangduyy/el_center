const { Button, Table, Popconfirm, message, Input, Space, Switch } = require("antd");
import { DeleteFilled, EditFilled, CopyOutlined } from "@ant-design/icons";
import Breadcrumb from "../../components/breadcrumbs";
import { useNavigate } from "react-router";
import { useQueryClient, useQuery } from "react-query";
import { Link, useLocation } from "react-router-dom";
import { css } from "@emotion/react";
import { useEffect, useState } from "react";
import { useDebounce } from "../../../lib/hook";
import moment from "moment";
import Calendar from "../../components/calendar";

const OrderPage = () => {
    const location = useLocation();
    const navigate = useNavigate();
    const queryClient = useQueryClient();
    const [search, setSearch] = useState(null);
    const [startDate, setStartDate] = useState();
    const [endDate, setEndDate] = useState();
    const [data, setData] = useState([]);
    const [isloading, setIsLoading] = useState(false);
    const [classes, setClasses] = useState([]);

    const userInfo = localStorage.getItem("user") ? JSON.parse(localStorage.getItem("user")) :  {};
    
    const debouncedSearchQuery = useDebounce(search, 600);

    const [pagination, setPagination] = useState({
        current: 1,
        pageSize: 5,
        total: 0,
    });

    useEffect(async () => {
        setIsLoading(true)
        const { data } = await axios.get("/api/admin/order/", {
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
            total: data.total,
        });
        setData(data.data);
        setIsLoading(false)
    }, [pagination.current, debouncedSearchQuery, startDate, endDate]);

    const handleTableChange = (pagination, filters, sorter) => {
        setPagination(pagination);
    };

    useEffect(async () => {
        const { data } = await axios.get("/api/admin/class");
        setClasses(data.data);
    }, []);

    const handleDelete = async (id) => {
        try {
            await axios.delete("/api/admin/order/" + id);
            setPagination({
                ...pagination,
                total: pagination.total - 1
            })
            message.success("Xoá đơn đăng ký thành công");
            queryClient.invalidateQueries("order");
            const newData = data.filter(item => item.id !== id);
            setData(newData);
        } catch ({ response }) {
            const { data } = response;
            message.error(data.error);
        }
    };

    const onChangeStatus = async (record) => {
        await axios.put("/api/admin/order/" + record.id, {
            ...record,
            status: !record.status,
        });
    };

    return (
        <div>
            <Breadcrumb items={["Đơn đăng ký"]}>
                <Space>
                    {
                        userInfo?.role != 'student' && 
                        <Button
                        onClick={() => navigate("/admin/order/new")}
                        className="ml-auto"
                        type="primary"
                        >
                        Thêm đơn đăng ký
                        </Button>
                    }
                 
                    <Input
                        placeholder="Tìm kiếm"
                        value={search}
                        onChange={(e) => setSearch(e.target.value)}
                    />
                    <Calendar
                        name = "startDate"
                        onChange={(date) => setStartDate(date)}
                        placeholder="Start date"
                    />
                    <Calendar
                        name = "endDate"
                        onChange={(date) => setEndDate(date)}
                        placeholder="End date"
                    />
                </Space>
            </Breadcrumb>
            <div
                className="site-layout-background"
                style={{ padding: 24, minHeight: 360 }}
            >
                <Table
                    footer={() => `Tổng số đơn đăng ký ${pagination.total}`}
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
                            dataIndex: "fullName",
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
                            title: "Giá tiền (đ)",
                            dataIndex: "total",
                            render: (text, record, index) => {
                                return (
                                    <span>
                                        {record.total.toLocaleString()}
                                    </span>
                                );
                            },
                        },
                        {
                            title: "Khoá học",
                            render: (text, record, index) => {
                                return (
                                    <span>
                                        {record.course?.title}
                                    </span>
                                );
                            },
                        },
                        {
                            title: "Ngày đăng ký",
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
                            title: "Trạng thái",
                            render: (text, record, index) => {
                                return (
                                    <Switch
                                        defaultChecked={record.status === 1}
                                        onChange={() => onChangeStatus(record)}
                                    />
                                );
                            },
                        },

                        {
                            title: "Thanh toán",
                            render: (text, record, index) => {
                                return (
                                    <a href={`/vnpay/checkout?orderId=${record.id}&total=${record.total}`} target="_blank">VNPAY</a>
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
                    dataSource={data}
                    loading={isloading}
                />
            </div>
        </div>
    );
};
export default OrderPage;
