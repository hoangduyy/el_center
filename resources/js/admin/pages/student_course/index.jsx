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

const StudentCoursePage = () => {
    const location = useLocation();
    const navigate = useNavigate();
    const queryClient = useQueryClient();
    const [search, setSearch] = useState(null);
    const [startDate, setStartDate] = useState();
    const [endDate, setEndDate] = useState();
    const [data, setData] = useState([]);
    const [isloading, setIsLoading] = useState(false)
    const [levels, setLevels] = useState([]);

    const debouncedSearchQuery = useDebounce(search, 600);

    const [pagination, setPagination] = useState({
        current: 1,
        pageSize: 5,
        total: 0,
    });

    useEffect(async () => {
        setIsLoading(true)
        const { data } = await axios.get("/api/admin/student/course", {
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

    useEffect(async () => {
        const { data } = await axios.get("/api/admin/level");
        setLevels(data.data);
    }, []);

    const handleTableChange = (pagination, filters, sorter) => {
        setPagination(pagination);
    };


    const onChangeStatus = async (record) => {
        await axios.put("/api/admin/course/" + record.id, {
            ...record,
            status: !record.status,
        });
    };
    

    return (
        <div>
            <Breadcrumb items={["Khoá học"]}>
                <Space>
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
                    footer={() => `Tổng số khoá học ${pagination.total}`}
                    rowKey={(record) => record.id}
                    pagination={pagination}
                    onChange={handleTableChange}
                    columns={[
                        {
                            title: "STT",
                            render: (text, record, index) => index + 1,
                        },
                        {
                            title: "Tên khoá học",
                            dataIndex: "title",
                            render: (text, record, index) => {
                                return (
                                    <span>{record.class.course.title}</span>
                                );
                            },
                        },
                        {
                            title: "Lớp",
                            render: (text, record, index) => {
                                return (
                                    <span>{record.class.title}</span>
                                );
                            },
                        },
                        {
                            title: "Giá (đ)",
                            render: (text, record, index) => {
                                return (
                                    <span>{record.class.course.price.toLocaleString()}</span>
                                );
                            },
                        },
                        {
                            title: "Số giờ học",
                            render: (text, record, index) => {
                                return (
                                    <span>{record.class.course.number_of_hours}</span>
                                );
                            },
                        },
                        {
                            title: "Đánh giá",
                            render: (text, record, index) => {
                                return (
                                    <span>{record.class.course.rate}</span>
                                );
                            },
                        },
                        {
                            title: "Ngày tạo",
                            render: (text, record, index) => {
                                return (
                                    <span>
                                        {moment(record.class.course.created_at).format(
                                            "DD/MM/YYYY, hh:mm"
                                        )}
                                    </span>
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
                            title: "Trạng thái",
                            render: (text, record, index) => {
                                return (
                                    <Switch
                                        defaultChecked={record.status === 1}
                                        onChange={() => onChangeStatus(record)}
                                        disabled
                                    />
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
export default StudentCoursePage;
