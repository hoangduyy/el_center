const {
    PageHeader,
    Button,
    Table,
    Popconfirm,
    message,
    Input,
    Tooltip,
} = require("antd");
import { DeleteFilled, EditFilled, CopyOutlined } from "@ant-design/icons";
import Breadcrumb from "../../components/breadcrumbs";
import { useNavigate } from "react-router";
import { useQueryClient, useQuery } from "react-query";
import { Link } from "react-router-dom";
import { css } from "@emotion/react";
import copy from "copy-to-clipboard";

const CampaignPage = () => {
    const navigate = useNavigate();
    const queryClient = useQueryClient();
    const { isLoading, data } = useQuery(["campaign"], async () => {
        const { data } = await axios.get("/api/admin/campaign");
        return data;
    });

    const handleDelete = async (id) => {
        try {
            await axios.delete("/api/admin/campaign/" + id);
            message.success("Xoá chiến dịch thành công");
            queryClient.invalidateQueries("campaign");
            const newData = data.filter(item => item.id !== id);
            setData(newData);
        } catch ({ response }) {
            const { data } = response;
            message.error(data.error);
        }
    };

    const copyLink = (link) => {
        console.log("a");
        copy(link);
        message.info("Đã copy link vào bộ nhớ");
    };

    return (
        <div>
            <Breadcrumb items={["Chiến dịch"]}>
                <Button
                    onClick={() => navigate("/admin/campaign/new")}
                    className="ml-auto"
                    type="primary"
                >
                    Thêm chiến dịch
                </Button>
            </Breadcrumb>
            <div
                className="site-layout-background"
                style={{ padding: 24, minHeight: 360 }}
            >
                <Table
                    rowKey={(record) => record.id}
                    loading={isLoading}
                    pagination={false}
                    columns={[
                        {
                            title: "STT",
                            render: (text, record, index) => index + 1,
                        },
                        {
                            title: "Tên chiến dịch",
                            render: (text, record) => (
                                <Link to={`/admin/lead?id=${record.id}`}>
                                    {record.name}
                                </Link>
                            ),
                        },
                        { title: "Slug", dataIndex: "slug" },
                        {
                            title: "Link",
                            render: (text, record, index) => (
                                <a href={record.url} target="_blank">
                                    {record.url}
                                </a>
                            ),
                        },
                        {
                            title: "Api",
                            render: (text, record, index) => {
                                return (
                                    <Input.Group key={index} compact>
                                        <Input
                                            value={`https://khoahoc.nobi.pro/api/lead/${record.id}`}
                                            readOnly
                                            disabled
                                            css={css`
                                                width: calc(
                                                    100% - 31px
                                                ) !important;
                                            `}
                                        />
                                        <Tooltip title="Copy link">
                                            <Button
                                                icon={
                                                    <CopyOutlined
                                                        onClick={() =>
                                                            copyLink(
                                                                `https://khoahoc.nobi.pro/api/lead/${record.id}`
                                                            )
                                                        }
                                                    />
                                                }
                                            />
                                        </Tooltip>
                                    </Input.Group>
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
                                            to={`/admin/campaign/${record.id}`}
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
export default CampaignPage;
