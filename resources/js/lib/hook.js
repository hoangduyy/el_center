import { useState, useEffect } from 'react';
import {
    matchPath,
    useLocation
} from "react-router-dom";
import routes from '../admin/routes';

export const useDebounce = (value, delay = 500) => {
    const [debouncedValue, setDebouncedValue] = useState(value);
    useEffect(() => {
        const handler = setTimeout(() => {
            setDebouncedValue(value);
        }, delay);

        // Cancel the timeout if value changes (also on delay change or unmount)
        return () => {
            clearTimeout(handler);
        };
    }, [value, delay]);

    return debouncedValue;
}


export const usePathPattern = () => {
    const { pathname } = useLocation();
    return matchPath(pathname, routes)?.path;
}
