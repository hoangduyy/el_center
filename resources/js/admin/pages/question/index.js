const { Button, Table, Popconfirm, message, Input, Space } = require("antd");
import { DeleteFilled, EditFilled, CopyOutlined } from "@ant-design/icons";
import Breadcrumb from "../../components/breadcrumbs";
import { useNavigate } from "react-router";
import { useQueryClient, useQuery } from "react-query";
import { Link, useLocation } from "react-router-dom";
import { css } from "@emotion/react";
import React, { useEffect, useState } from "react";
import { useDebounce } from "../../../lib/hook";

import moment from "moment";
import Calendar from "../../components/calendar";

const ListQuestionPage = () => {
    const navigate = useNavigate();
    const queryClient = useQueryClient();
    const [search, setSearch] = useState(null);
    const [startDate, setStartDate] = useState();
    const [endDate, setEndDate] = useState();
    const [data, setData] = useState([]);

    const debouncedSearchQuery = useDebounce(search, 600);

    const [pagination, setPagination] = useState({
        current: 1,
        pageSize: 5,
        total: 0,
    });

    useEffect(async () => {
        const { data } = await axios.get("/api/admin/question", {
            params: {
                page: pagination.current,
                pageSize: pagination.pageSize,
                search: debouncedSearchQuery,
                start_date: startDate
                ? moment(startDate, "DD-MM-YYYY").format("YYYY-MM-DD")
                : null,
                end_date: endDate
                ? moment(endDate, "DD-MM-YYYY").format("YYYY-MM-DD")
                : null,
            },
        });
        setPagination({
            ...pagination,
            total: data.total,
        });
        setData(data.data);
    }, [pagination.current, search, startDate, endDate]);

    const handleTableChange = (pagination, filters, sorter) => {
        setPagination(pagination);
    };

    const handleDelete = async (id) => {
        try {
            await axios.delete("/api/admin/question/" + id);
            setPagination({
                ...pagination,
                total: pagination.total - 1
            })
            message.success("Xoá thành công");
            queryClient.invalidateQueries("question");
            const newData = data.filter(item => item.id !== id);
            setData(newData);
        } catch ({ response }) {
            const { data } = response;
            message.error(data.error);
        }
    };

    return (
        <div>
            <Breadcrumb items={["Bộ câu hỏi"]}>
                <Space>
                    <Button
                        onClick={() => navigate("/admin/question/new")}
                        className="ml-auto"
                        type="primary"
                    >
                        Thêm câu hỏi
                    </Button>
                </Space>
            </Breadcrumb>
            <div
                className="site-layout-background"
                style={{ padding: 24, minHeight: 360 }}
            >
                <Table
                    footer={() => `Tổng số câu hỏi ${pagination.total}`}
                    rowKey={(record) => record.id}
                    pagination={pagination}
                    onChange={handleTableChange}
                    columns={[
                        {
                            title: "STT",
                            width: '30px',
                            render: (text, record, index) => index + 1,
                        },
                        {
                            title: "ID",
                            width: '30px',
                            render: (text, record, index) => {
                                return (
                                    <span>
                                        {record.id ? record.id : ""}
                                    </span>
                                );
                            },
                        },
                        {
                            title: "Câu hỏi",
                            width: '20%',
                            render: (text, record, index) => {
                                return (
                                    <span>
                                        {record.question ? record.question : ""}
                                    </span>
                                );
                            },
                        },
                        {
                            title: "Đáp án A",
                            width: '15%',
                            render: (text, record, index) => {
                                return (
                                    <span>
                                        {record.da_a ? record.da_a : ""}
                                    </span>
                                );
                            },
                        },
                        {
                            title: "Đáp án B",
                            width: "15%",
                            render: (text, record) => (
                              <>
                              <span
                                    style={{ cursor: "pointer"}}
                                  >
                                    {record.da_b ? record.da_b : ""}
                                  </span>
                              </>
                            ),
                          },
                        {
                            title: "Đáp án C",
                            width: "15%",
                            render: (text, record, index) => {
                                return (
                                    <span>
                                        {record.da_c ? record.da_c : ""}
                                    </span>
                                );
                            },
                        },
                        {
                            title: "Đáp án D",
                            width: "15%",
                            render: (text, record, index) => {
                                return (
                                    <span>
                                       {record.da_d ? record.da_d : ""}
                                    </span>
                                );
                            },
                        },
                        {
                            title: "Đáp án đúng",
                            width: "15%",
                            render: (text, record, index) => {
                                return (
                                    <span>
                                        {record.da ? record.da : "A"}
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
                                            to={`/admin/question/${record.id}/edit`}
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
                />
            </div>
        </div>
    );
};
export default ListQuestionPage;
