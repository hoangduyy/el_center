import { Select, Spin } from 'antd';
import { useQuery } from 'react-query';
import { useState, useEffect } from 'react';

const TemplateSelect = ({ onChange, value, ...props }) => {

    const { isLoading, data } = useQuery(['template'], async () => {
        const { data } = await axios.get("/api/admin/template");
        return data;
    });

    return (
        <Select
            notFoundContent={isLoading ? <Spin size="small" /> : null}
            onChange={onChange}
            optionLabelProp="label"
            value={value}
            {...props}
            options={data?.map(item => ({
                label: item.name,
                value: item.id,
            }))}
        />
    );
};
export default TemplateSelect;
