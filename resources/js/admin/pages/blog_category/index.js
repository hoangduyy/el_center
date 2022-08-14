const { Button, Table, Popconfirm, message, Input, Space } = require("antd");
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

const BlogCategoryPage = () => {
    const location = useLocation();
    const navigate = useNavigate();
    const queryClient = useQueryClient();
    const [search, setSearch] = useState(null);
    const [startDate, setStartDate] = useState();
    const [endDate, setEndDate] = useState();
    const [data, setData] = useState([]);
    const [isloading, setIsLoading] = useState(false)

    const debouncedSearchQuery = useDebounce(search, 600);

    const [pagination, setPagination] = useState({
        current: 1,
        pageSize: 5,
        total: 0,
    });

    useEffect(async () => {
        setIsLoading(true)
        const { data } = await axios.get("/api/admin/blog-category/", {
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
    }, [pagination.current, debouncedSearchQuery, startDate, endDate, pagination.total]);

    const handleTableChange = (pagination, filters, sorter) => {
        setPagination(pagination);
    };

    const handleDelete = async (id) => {
        try {
            await axios.delete("/api/admin/blog-category/" + id);
            setPagination({
                ...pagination,
                total: pagination.total - 1
            })

            message.success("Xoá tin tức thành công");
            queryClient.invalidateQueries("blog-category");
        } catch ({ response }) {
            const { data } = response;
            message.error(data.error);
        }
    };

    return (
        <div>
            <Breadcrumb items={["Tin tức"]}>
                <Space>
                    <Button
                        onClick={() => navigate("/admin/blog/category/new")}
                        className="ml-auto"
                        type="primary"
                    >
                        Thêm tin tức
                    </Button>
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
                    footer={() => `Tổng số tin tức ${pagination.total}`}
                    rowKey={(record) => record.id}
                    pagination={pagination}
                    onChange={handleTableChange}
                    columns={[
                        {
                            title: "STT",
                            render: (text, record, index) => index + 1,
                        },
                        {
                            title: "Tên tiêu đề",
                            dataIndex: "name",
                        },
                        {
                            title: "Đường dẫn",
                            dataIndex: "slug",
                        },
                        {
                            title: "Mô tả",
                            dataIndex: "description",
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
                            width: 100,
                            render: (text, record, index) => {
                                return (
                                    <div key={index}>
                                        <Link
                                            className="mr-2"
                                            to={`/admin/blog/category/${record.id}`}
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
export default BlogCategoryPage;
