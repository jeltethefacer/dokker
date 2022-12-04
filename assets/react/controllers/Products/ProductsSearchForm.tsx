import React, { useEffect, useState } from "react";
import axios, { AxiosResponse } from "axios";

interface ProductSearchParameters {
  name: string | null;
  price: number | null;
}

interface Product {
  id: number;
  name: string;
  price_minor_amount: string;
  currency_id: string;
}

export default function ProductsSearchForm(props: { search_url: string }) {
  const [searchParams, setSearchParams] = useState<ProductSearchParameters>({
    name: null,
    price: null,
  });
  const [products, setProducts] = useState<Product[]>([]);

  const onSubmit = (event: React.FormEvent): void => {
    event.preventDefault();
    axios
      .get(props.search_url, {
        params: {
          _name: searchParams.name,
          _price: searchParams.price,
        },
      })
      .then((response: AxiosResponse<Product[]>) => {
        setProducts(response.data);
      })
      .catch((): void => {});
  };

  return (
    <>
      <form onSubmit={onSubmit}>
        <div className="grid grid-cols-3 gap-4">
          <div className="flex flex-col">
            <label htmlFor="_name">
              Name:
              <input
                aria-label="Name"
                className="w-full"
                type="text"
                name="_name"
                autoComplete="on"
                value={searchParams.name || ""}
                onChange={(event): void =>
                  setSearchParams({
                    ...searchParams,
                    name: event.target.value || null,
                  })
                }
              />
            </label>
          </div>
          <div className="flex flex-col">
            <label htmlFor="_price">
              Price:
              <input
                aria-label="Price"
                className="w-full"
                type="number"
                step="0.01"
                name="_price"
                autoComplete="on"
                value={searchParams.price || ""}
                onChange={(event): void =>
                  setSearchParams({
                    ...searchParams,
                    price: parseFloat(event.target.value) || null,
                  })
                }
              />
            </label>
          </div>
        </div>
        <div className="flex justify-end my-2">
          <button
            type="submit"
            className="group align relative rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
          >
            Search
          </button>
        </div>
      </form>
      <hr />

      <div className="overflow-x-auto relative shadow-md sm:rounded-lg">
        <table className="w-full text-sm text-left text-gray-500 dark:text-gray-400">
          <thead className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
              <th scope="col" className="py-3 px-6">
                Product name
              </th>
              <th scope="col" className="py-3 px-6">
                Price
              </th>
              <th scope="col" className="py-3 px-6" />
            </tr>
          </thead>
          <tbody>
            {products.map((product) => {
              return (
                <tr
                  key={product.id}
                  className="bg-white border-b dark:bg-gray-900 dark:border-gray-700"
                >
                  <th
                    scope="row"
                    className="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                  >
                    {product.name}
                  </th>
                  <td className="py-4 px-6">{product.price_minor_amount}</td>
                  <td className="py-4 px-6">
                    <a
                      href={`/products/${product.id}`}
                      className="font-medium text-indigo-600 hover:underline"
                    >
                      Edit
                    </a>
                  </td>
                </tr>
              );
            })}
          </tbody>
        </table>
      </div>
    </>
  );
}
