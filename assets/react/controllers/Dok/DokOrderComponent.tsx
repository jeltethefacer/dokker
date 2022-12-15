import React, { useState } from "react";
import axios, { AxiosResponse } from "axios";
import Select, { GroupBase, Options } from "react-select";
import {
  OptionsOrGroups,
  SingleValue,
} from "react-select/dist/declarations/src/types";
import { ValueType } from "tailwindcss/types/config";
import Option from "react-select/dist/declarations/src/components/Option";

interface ProductSearchParameters {
  name: string | null;
  price: number | null;
}

interface Product {
  id: number;
  name: string;
  price_minor_amount: number;
  currency_id: string;
}

interface Cart {
  user_id: number | null;
  cart_items: CartItem[];
}

interface CartItem {
  product_id: number;
  quantity: number;
}

interface User {
  id: number;
  name: string | null;
  image_url: string | null;
}

const defaultCart: Cart = {
  cart_items: [],
  user_id: null,
};

interface UserOption {
  value: number;
  label: string;
}

export default function DokOrderComponent(props: {
  products: Product[];
  users: User[];
}) {
  const [cart, setCart] = useState<Cart>(defaultCart);
  const [errorMessage, setErrorMessage] = useState<string | null>(null);

  const options: UserOption[] = props.users.map(
    (user: User): { value: number; label: string } => {
      return {
        value: user.id,
        label: user.name,
      };
    }
  );

  const addProduct = (productId: number) => {
    setCart((prevCart) => {
      let alreadyInCart = false;
      const newCartItems = cart.cart_items.map((cartItem) => {
        if (cartItem.product_id === productId) {
          alreadyInCart = true;
          return {
            ...cartItem,
            quantity: cartItem.quantity + 1,
          };
        }

        return {
          ...cartItem,
        };
      });

      if (!alreadyInCart) {
        newCartItems.push({
          quantity: 1,
          product_id: productId,
        });
      }

      return {
        ...cart,
        cart_items: newCartItems,
      };
    });
  };

  const onUserChange = (newValue: UserOption | null): void => {
    setCart({ ...cart, user_id: newValue.value });
  };

  const onCreateOrder = (): void => {
    if (!cart.user_id) {
      setErrorMessage("Please enter a user.");
      return;
    }
    if (cart.cart_items.length === 0) {
      setErrorMessage("Please enter a product.");
      return;
    }

    setErrorMessage(null);
    axios
      .post("/order", cart)
      .then(() => {
        setCart(defaultCart);
      })
      .catch(() => {
        setErrorMessage("Something went wrong please try again.");
      });
  };

  return (
    <div className="grid grid-cols-3">
      <div className="col-span-2">
        <div className="grid grid-cols-4 gap-4">
          {props.products.map((product: Product) => {
            return (
              <div
                key={product.id}
                className="col-span-1 max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-700"
                onClick={(): void => addProduct(product.id)}
                onKeyDown={(): void => addProduct(product.id)}
              >
                <h5 className="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                  {product.name}
                </h5>

                <p className="mb-3 font-normal text-gray-700 dark:text-gray-400">
                  {product.price_minor_amount}
                </p>
                <button
                  type="button"
                  className="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                >
                  Add
                </button>
              </div>
            );
          })}
        </div>
      </div>
      <div className="col-span-1">
        <table className="w-full text-sm text-left text-gray-500 dark:text-gray-400">
          <thead className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
              <th scope="col" className="py-3 px-6">
                Product
              </th>
              <th scope="col" className="py-3 px-6">
                Qty.
              </th>
              <th scope="col" className="py-3 px-6">
                Unit
              </th>
              <th scope="col" className="py-3 px-6">
                Sum
              </th>
            </tr>
          </thead>
          <tbody>
            {cart.cart_items.map((cartItem) => {
              const product = props.products.find(
                (product): boolean => product.id === cartItem.product_id
              );
              if (!product) {
                return <div key={cartItem.product_id} />;
              }
              return (
                <tr
                  key={cartItem.product_id}
                  className="bg-white border-b dark:bg-gray-900 dark:border-gray-700"
                >
                  <td className="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {product.name}
                  </td>
                  <td className="py-4 px-6">{cartItem.quantity}</td>
                  <td className="py-4 px-6">{product.price_minor_amount}</td>
                  <td className="py-4 px-6">
                    {product.price_minor_amount * cartItem.quantity}
                  </td>
                </tr>
              );
            })}
            <tr className="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
              <td className="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                Total
              </td>
              <td className="py-4 px-6" />
              <td className="py-4 px-6" />
              <td className="py-4 px-6">
                {cart.cart_items.reduce((sum, cartItem) => {
                  const product = props.products.find(
                    (product): boolean => product.id === cartItem.product_id
                  );
                  if (!product) {
                    return sum;
                  }
                  return sum + cartItem.quantity * product.price_minor_amount;
                }, 0)}
              </td>
            </tr>
          </tbody>
        </table>
        <Select
          className="mt-2"
          options={options}
          onChange={onUserChange}
          value={options.filter((option) => option.value === cart.user_id)}
        />
        {errorMessage && (
          <div
            className="bg-red-100 border border-red-400 text-red-700 px-4 py-3 mt-2 rounded relative"
            role="alert"
          >
            <span className="block sm:inline">{errorMessage}</span>
          </div>
        )}

        <button
          type="button"
          className="group relative flex w-full justify-center rounded-md border border-transparent bg-indigo-600 py-2 mt-2 px-4 text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
          onClick={onCreateOrder}
        >
          Create order
        </button>
      </div>
    </div>
  );
}
