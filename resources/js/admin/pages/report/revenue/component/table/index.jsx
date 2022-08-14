import React from "react";
import { Table } from "antd";
export default function TableOverview({ data, listDates }) {
    const dataTable = [];
    if(data.length === listDates .length){
        listDates.forEach((item, index) => {
            dataTable.push({
                date: item,
                totalOrder: data[index]["totalOrder"],
                totalProduct: data[index]["totalProduct"],
                totalOrderSuccess: data[index]["totalOrderSuccess"],
                totalAmount: data[index]["totalAmount"],
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
            title: "Số đơn",
            dataIndex: "totalOrder",
            key: "totalOrder",
        },
        {
            title: "Đơn chốt",
            dataIndex: "totalOrderSuccess",
            key: "totalOrderSuccess",
        },
        {
            title: "Doanh số (đ)",
            dataIndex: "totalAmount",
            key: "totalAmount",
            render: (_, record) => (
                <span>{record.totalAmount.toLocaleString()}</span>
            ),
        },
    ];

    return (
        <Table columns={columns} dataSource={dataTable} pagination={false} />
    );
}
