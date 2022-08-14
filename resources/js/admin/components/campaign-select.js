import { Select, Spin } from 'antd';
import { useQuery } from 'react-query';
import { useState, useEffect } from 'react';
import { useDebounce } from '../../lib/hook';

const CampaignSelect = ({ onChange, value, ...props }) => {
    const [search, setSearch] = useState(null);

    const debouncedSearchQuery = useDebounce(search, 600);

    const { isLoading, data } = useQuery(['campaign', debouncedSearchQuery], async () => {
        const { data } = await axios.get("/api/admin/campaign", {
            params: {
                search: debouncedSearchQuery
            }
        });
        return data.map(item => ({
            label: item.name,
            value: item.id,
        }));
    });

    return (
        <Select
            showSearch
            filterOption={false}
            onSearch={search => setSearch(search)}
            notFoundContent={isLoading ? <Spin size="small" /> : null}
            onChange={onChange}
            value={value}
            {...props}
            options={data}
        />
    );
};
export default CampaignSelect;
