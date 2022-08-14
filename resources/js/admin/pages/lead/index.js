import { useSearchParams, useLocation, useParams } from "react-router-dom";
import { useQuery } from 'react-query';
import { Result, Space, Table, Input } from 'antd';
import Breadcrumb from '../../components/breadcrumbs';
import CampaignSelect from '../../components/campaign-select';
import { useState, useEffect } from 'react';
import { css } from '@emotion/react';
import {useDebounce } from '../../../lib/hook';

const LeadPage = () => {
    let [searchParams, setSearchParams] = useSearchParams();
    const location = useLocation();
    const { id } = Object.fromEntries(new URLSearchParams(location.search));
    const [search, setSearch] = useState(null);

    const debouncedSearchQuery = useDebounce(search, 600);

    const [pagination, setPagination] = useState({
        current: 1,
        pageSize: 20,
        total: 0
    })

    const [campaignId, setCampaignId] = useState(id);

    const { data, isLoading, refetch } = useQuery(["lead", campaignId, pagination, debouncedSearchQuery], async () => {
        const { data } = await axios.get("/api/admin/lead/" + campaignId, {
            params: {
                page: pagination.current,
                pageSize: pagination.pageSize,
                search: debouncedSearchQuery
            }
        });
        setPagination({
            ...pagination,
            total: data.total
        });
        return data.data;
    }, {
        enabled: !!campaignId
    })

    const handleChangeCampaign = (value) => {
        setSearchParams({ id: value })
        setCampaignId(value);
    }

    const handleTableChange = (pagination, filters, sorter) => {
        setPagination(pagination)
    };

    return (
        <div>
            <Breadcrumb items={["Lead"]} >
                <Space>
                    <CampaignSelect
                        css={css`width:200px;`}
                        value={campaignId}
                        onChange={handleChangeCampaign}
                        placeholder={"Chiến dịch"}
                    />
                    <Input
                        placeholder="Tìm kiếm"
                        value={search}
                        onChange={e =>setSearch(e.target.value)}
                    />
                </Space>
            </Breadcrumb>
            <Table
                footer={() => `Tổng số lead ${pagination.total}`}
                rowKey={record => record.id}
                pagination={pagination}
                onChange={handleTableChange}
                columns={[
                    { title: "STT", render: (text, record, index) => index + 1 },
                    { title: "Họ tên", dataIndex: "name" },
                    { title: "SĐT", dataIndex: "phone" },
                    { title: "Email", dataIndex: "email" },
                    { title: "Ref", dataIndex: "ref" },
                    { title: "Đã mời", dataIndex: "invited_count" },
                ]}
                dataSource={data}
                loading={isLoading}
            />
        </div>
    )
}

export default LeadPage;
