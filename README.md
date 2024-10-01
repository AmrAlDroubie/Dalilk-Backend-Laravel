# 📋 API Endpoints Overview

## Authentication Routes

-   **POST** `/api/checktoken`  
    **Controller**: `AuthController@checkToken`  
    **Description**: Verify token validity.

-   **POST** `/api/login`  
    **Controller**: `AuthController@login`  
    **Description**: User login.

-   **POST** `/api/login/admin`  
    **Controller**: `AuthController@loginAdmin`  
    **Description**: Admin login.

-   **POST** `/api/logout`  
    **Controller**: `AuthController@logout`  
    **Description**: User logout.

-   **POST** `/api/signup`  
    **Controller**: `AuthController@signup`  
    **Description**: User signup.

---

## Pharmacy Routes

-   **DELETE** `/api/{id}/delete`  
    **Controller**: `PharmacyController@destroy`  
    **Description**: Delete pharmacy by ID.

-   **GET | HEAD** `/api/{id}/editinfo`  
    **Controller**: `PharmacyController@show`  
    **Description**: Show pharmacy info for editing.

-   **PATCH** `/api/{id}/editinfo/update`  
    **Controller**: `PharmacyController@update`  
    **Description**: Update pharmacy info.

---

## Medicine Routes

-   **GET | HEAD** `/api/{id}/medicine`  
    **Controller**: `MedicineController@index`  
    **Description**: View list of medicines for the specified pharmacy.

-   **POST** `/api/{id}/medicine/add`  
    **Controller**: `MedicineController@store`  
    **Description**: Add new medicine to the pharmacy.

-   **DELETE** `/api/{id}/medicine/{medicine_id}/delete`  
    **Controller**: `MedicineController@destroy`  
    **Description**: Delete a specific medicine.

-   **PATCH** `/api/{id}/medicine/{medicine_id}/update`  
    **Controller**: `MedicineController@update`  
    **Description**: Update details of a specific medicine.

---

## Search Routes

-   **GET | HEAD** `/api/search/{name}/{city?}`  
    **Controller**: `MedicineController@search`  
    **Description**: Search for medicines by name and optional city.
