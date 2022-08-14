import { useState } from "react";
import { PageHeader, Button, Table, Popconfirm, message, Input, Drawer, Space } from "antd"
import { DeleteFilled, EditFilled, CopyOutlined } from '@ant-design/icons';
import Breadcrumb from '../../components/breadcrumbs';
import { useNavigate } from 'react-router';
import { useQueryClient, useQuery } from 'react-query';
import { Link } from 'react-router-dom';
import { css } from '@emotion/react';

const TemplatePage = () => {
    const [preview, setPreview] = useState(null);
    const navigate = useNavigate();
    const queryClient = useQueryClient();
    const { isLoading, data } = useQuery(['template'], async () => {
        const { data } = await axios.get("/api/admin/template");
        return data;
    });

    const handleDelete = async (id) => {
        try {
            await axios.delete("/api/admin/template/" + id);
            message.success("Xoá mẫue mail thành công");
            queryClient.invalidateQueries("template");
        } catch ({ response }) {
            const { data } = response;
            message.error(data.error);
        }
    }

    return <div>
        <Breadcrumb items={["Mẫu email"]} >
            <Button onClick={() => navigate("/admin/template/new")} className="ml-auto" type="primary">Thêm mẫu email</Button>
        </Breadcrumb>
        <div className="site-layout-background" style={{ padding: 24, minHeight: 360 }}>
            <Table
                rowKey={record => record.id}
                loading={isLoading}
                pagination={false}
                columns={[
                    { title: "STT", render: (text, record, index) => index + 1 },
                    { title: 'Tên chiến dịch',render:(text,record, index)=> record.name },
                    {
                        title: 'Preview', render: (text, record, index) => <Button
                            onClick={() => setPreview(record)}
                        >Xem thử</Button>
                    },
                    {
                        width: 100, render: (text, record, index) => {
                            return <div key={index}>
                                <Link className="mr-2" to={`/admin/template/${record.id}`} ><EditFilled /></Link>
                                <Popconfirm title="Xác nhận xoá" onConfirm={() => handleDelete(record.id)}>
                                    <DeleteFilled css={css`color:red`} />
                                </Popconfirm>
                            </div>
                        }
                    },
                ]}
                dataSource={data}
            />
        </div>
        {
            preview &&
            <Drawer
                title={preview.name}
                placement="right"
                size={"large"}
                onClose={() => setPreview(null)}
                visible={!!preview}
                extra={
                    <Space>
                        <Button onClick={() => setPreview(null)}>Đóng</Button>
                    </Space>
                }
            >
                <iframe css={css`width:100%;border:none;
                height:100vh`} srcDoc={preview.html} />
            </Drawer>
        }
    </div>
}
export default TemplatePage;
