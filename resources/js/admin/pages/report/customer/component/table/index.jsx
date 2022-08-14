import React from "react";
import { Table, Tag, Space } from "antd";
export default function TableOverview({ data, listDates }) {
    const dataTable = [];
    if (data.length === listDates.length) {
        listDates.forEach((item, index) => {
            dataTable.push({
                date: item,
                totalNewCustomer: data[index]["totalNewCustomer"],
                totalOldCustomer: data[index]["totalOldCustomer"],
            });
        });
    }

    const columns = [
        {
            title: "Thời gian",
            dataIndex: "date",
            key: "date",
            render: (_, record) => <span>{record.date}</span>,
        },
        {
            title: "Học viên mới",
            dataIndex: "totalNewCustomer",
            key: "totalNewCustomer",
        },
        {
            title: "Học viên cũ",
            dataIndex: "totalOldCustomer",
            key: "totalOldCustomer",
        },
    ];

    return (
        <Table columns={columns} dataSource={dataTable} pagination={false} />
    );
}
