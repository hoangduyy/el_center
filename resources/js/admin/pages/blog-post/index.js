const {
    Button,
    Table,
    Popconfirm,
    message,
    Input,
    Space,
    Switch,
} = require("antd");
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

const BlogPostPage = () => {
    const location = useLocation();
    const navigate = useNavigate();
    const queryClient = useQueryClient();
    const [search, setSearch] = useState(null);
    const [startDate, setStartDate] = useState();
    const [endDate, setEndDate] = useState();
    const [data, setData] = useState([]);
    const [isloading, setIsLoading] = useState(false);

    const debouncedSearchQuery = useDebounce(search, 600);

    const [pagination, setPagination] = useState({
        current: 1,
        pageSize: 5,
        total: 0,
    });

    useEffect(async () => {
        setIsLoading(true);
        const { data } = await axios.get("/api/admin/blog-post/", {
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
        setIsLoading(false);
    }, [pagination.current, debouncedSearchQuery, startDate, endDate]);

    const handleTableChange = (pagination, filters, sorter) => {
        setPagination(pagination);
    };

    const handleDelete = async (id) => {
        try {
            await axios.delete("/api/admin/blog-post/" + id);
            setPagination({
                ...pagination,
                total: pagination.total - 1
            })
            message.success("Xoá bài viết thành công");
            queryClient.invalidateQueries("blog-post");
            const newData = data.filter(item => item.id !== id);
            setData(newData);
        } catch ({ response }) {
            const { data } = response;
            message.error(data.error);
        }
    };

    const sortContent = (content) => {
        if (content.length > 10) {
            return `${content.slice(0, 10)}` + "...";
        } else {
            return content;
        }
    };

    const onChange = async (record) => {
        await axios.put("/api/admin/blog-post/" + record.id, {
            ...record,
            status: !record.status,
        });
    };

    return (
        <div>
            <Breadcrumb items={["Bài viết"]}>
                <Space>
                    <Button
                        onClick={() => navigate("/admin/blog/post/new")}
                        className="ml-auto"
                        type="primary"
                    >
                        Thêm bài viết 
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
            <div
                className="site-layout-background"
                style={{ padding: 24, minHeight: 360 }}
            >
                <Table
                    footer={() => `Tổng số bài viết  ${pagination.total}`}
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
                            dataIndex: "title",
                        },
                        {
                            title: "Ảnh đại diện",
                            render: (text, record, index) => {
                                return (
                                    <img
                                        src={record.thumbnail}
                                        alt={record.title}
                                        style={{
                                            width: "50px",
                                            height: "50px",
                                        }}
                                    />
                                );
                            },
                        },
                        {
                            title: "Nội dung",
                            render: (text, record, index) => {
                                return (
                                    <div
                                        dangerouslySetInnerHTML={{
                                            __html: sortContent(record.content),
                                        }}
                                    ></div>
                                );
                            },
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
                            title: "Trạng thái",
                            render: (text, record, index) => {
                                return (
                                    <Switch
                                        defaultChecked={record.status === 1}
                                        onChange={() => onChange(record)}
                                    />
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
                                            to={`/admin/blog/post/${record.id}`}
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
export default BlogPostPage;
