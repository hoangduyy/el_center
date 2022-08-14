import React, { createContext, useState } from 'react'

const MenuContext = createContext();

export const MenuProvider = ({ children }) => {
    const [collapsed, setCollapsed] = useState(false);

    const toggleMenu = ()=>{
        setCollapsed(!collapsed)
    }
    return (
        <MenuContext.Provider value={{ collapsed, toggleMenu }}>
            {children}
        </MenuContext.Provider>
    )
}

export default MenuContext;
