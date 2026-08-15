# CLAUDE.md

## Project Overview

This project is **Tigabenang**, a vendor management portal for a garment
and textile business.

Tigabenang helps vendors/admins manage:

-   Products
-   Materials and inventory
-   Size charts
-   3D garment models
-   Customer orders
-   Analytics
-   Vendor account and authentication

The application is designed as a standalone system for a hackathon. It
does **not** depend on a real external business partner or supplier
integration.

The main goal is to demonstrate a realistic and coherent digital
workflow from customer order submission to vendor/admin processing.

------------------------------------------------------------------------

## Brand Identity

### Brand

**Tigabenang**

### Product Name

**Tigabenang Vendor Management Portal**

### Brand Context

Tigabenang is a garment/textile-oriented platform focused on custom
products, materials, sizing, virtual fitting, and order management.

### Visual Style

Use the existing visual direction consistently across every page:

-   Warm off-white background
-   White content cards
-   Terracotta / burnt-orange primary accent
-   Dark charcoal typography
-   Thin light terracotta borders
-   Premium fashion and textile editorial aesthetic
-   Clean and spacious layouts
-   Minimal rounded corners
-   Subtle shadows only when necessary
-   No gradients
-   No excessive decorative elements
-   Professional but approachable
-   Desktop-first, responsive on smaller screens

Do not introduce a completely different visual style on individual
pages.

------------------------------------------------------------------------

# Core Product Workflow

The application should follow this simplified workflow:

``` text
Customer
    ↓
Submit Order Form
    ↓
Order appears in Admin Order Management
    ↓
Admin reviews order
    ↓
Admin communicates with customer through WhatsApp
    ↓
Price is negotiated
    ↓
Admin manually enters final agreed price
    ↓
Order is confirmed
    ↓
Material stock is deducted automatically
    ↓
Order proceeds through production
    ↓
Order completed
```

The system is intentionally simplified for a hackathon.

There is no direct supplier integration.

There is no automatic WhatsApp pricing negotiation.

There is no payment gateway requirement.

------------------------------------------------------------------------

# Authentication

Authentication consists of:

## Login

Fields:

-   Email Address
-   Password

Features:

-   Show/hide password
-   Forgot password
-   Sign In
-   Link to Register

Placeholder:

``` text
vendor@example.com
```

## Register

Fields:

-   Full Name
-   Business / Vendor Name
-   Email Address
-   Phone Number
-   Password
-   Confirm Password

Additional:

-   Terms of Service and Privacy Policy checkbox
-   Create Account button
-   Link back to Login

Flow:

``` text
Register → Login → Dashboard
```

After successful registration, redirect the user to Login.

Do not immediately redirect new users to the Dashboard.

------------------------------------------------------------------------

# Main Navigation

The admin portal navigation should contain:

1.  Dashboard
2.  Products
3.  Materials
4.  Size Charts
5.  3D Models
6.  Orders
7.  Analytics
8.  Settings

Do not add unnecessary navigation items unless the feature is actually
implemented.

------------------------------------------------------------------------

# Dashboard

The Dashboard is an operational command center.

Its purpose is to answer:

-   What is happening right now?
-   What needs attention?
-   What should the admin do next?

Do not turn the Dashboard into a duplicate Analytics page.

## Header

Title:

``` text
Dashboard Overview
```

Subtitle:

``` text
Monitor orders, inventory, products, and virtual fitting performance.
```

Actions:

-   Export Report
-   New Product

## KPI Cards

Show:

### Total Orders

Example:

``` text
156
This month
```

### Pending Orders

Example:

``` text
18
Awaiting review
```

### Waiting Price

Example:

``` text
7
Price needs to be finalized
```

### Low Stock

Example:

``` text
5
Materials below reorder level
```

Do not use "Active Production" as a primary KPI if production is not
part of the current workflow.

## Orders Needing Action

This is the primary Dashboard section.

Columns:

-   Order ID
-   Customer
-   Product
-   Status
-   Action

Relevant statuses:

-   New
-   Under Review
-   Waiting Price
-   Confirmed
-   In Production
-   Completed
-   Cancelled

The `Waiting Price` status is important because the final price is
negotiated through WhatsApp and entered manually by the admin.

## Material Alerts

Show only materials requiring attention.

Example:

``` text
Baby Terry
Available: 40 m
Reorder Level: 200 m
Low Stock
View Material
```

Detailed material management remains inside Materials.

## Recent Orders

Show a compact list of recent orders.

Columns:

-   Order ID
-   Customer
-   Product
-   Final Price
-   Status
-   Date

## Product Overview

Show:

-   Total Products
-   3D Models Linked
-   Incomplete Products

Example:

``` text
142 Products
98 3D Models
5 Incomplete
```

These values should come from product data, not hardcoded duplicate
data.

## Virtual Fitting Snapshot

Keep this compact.

Show:

-   Average Fit Score
-   Most Tried Product
-   Most Recommended Size
-   Total Fitting Sessions

Detailed analysis belongs in Analytics.

## Quick Actions

Useful actions:

-   New Product
-   Add Stock
-   New Order
-   Upload 3D Model

------------------------------------------------------------------------

# Products

Products are the main garment catalog.

The Product Catalog should manage:

-   Product name
-   SKU
-   Category
-   Price
-   Product images
-   Description
-   Materials
-   Available colors
-   Size chart
-   3D model
-   Product visibility/status

Example product:

``` text
Custom Hoodie
SKU: FV-HOD-001
Category: Hoodie
Price: Rp125.000
```

Product statuses may include:

-   Draft
-   Published
-   Ready
-   Archived

## Product Detail

The Product Detail page should be an actual management form, not merely
a display page.

Sections:

### Product Information

-   Product Name
-   SKU
-   Category
-   Description
-   Product Gallery

### Pricing

-   Base Price
-   Customization Fee
-   Final Starting Price

The final customer price is not necessarily determined here because
order prices can be negotiated manually.

### Materials

Products may reference materials from the Material Inventory.

Do not create duplicate material records inside Products.

### Available Colors

Manage supported colors for the product.

### Size Chart

Assign an existing Size Chart to the product.

Do not duplicate size chart data manually if the product can reference
an existing chart.

### 3D Model

Assign an existing 3D Model to the product.

Do not duplicate the actual model asset.

### Virtual Fitting Readiness

Show whether required data exists:

-   Product Info
-   Pricing
-   Materials
-   Colors
-   Size Chart
-   3D Model

### Product Visibility

Options:

-   Published
-   Draft
-   Archived

------------------------------------------------------------------------

# Materials

Materials represent physical textile inventory.

The Materials page should manage:

-   Material name
-   SKU
-   Category
-   Color / variant
-   Composition
-   Weight
-   Current stock
-   Cost per meter
-   Reorder level
-   Supplier information
-   Stock transactions

## Material Inventory

Example:

``` text
Cotton Fleece
SKU: FV-CF-001
Black
100% Cotton
280 g/m²
```

Inventory should show:

-   Current stock
-   Available stock
-   Reorder level
-   Status

Possible statuses:

-   In Stock
-   Low Stock
-   Out of Stock

## Adding Stock

The system is standalone.

There is no real supplier API.

Therefore, stock increases through a manual:

``` text
+ Add Stock
```

action.

When the admin adds stock, record:

-   Quantity
-   Date
-   Optional note

Then:

``` text
current_stock = current_stock + added_quantity
```

A stock transaction should be recorded for traceability.

Example:

``` text
11 Aug 2026
Cotton Fleece
Stock In
+500 m
```

## Reducing Stock

When a confirmed order requires material, stock can be deducted
automatically according to the order's material quantity.

Example:

``` text
Current Stock: 1,250 m
Order Allocation: -50 m
New Stock: 1,200 m
```

Do not require the admin to manually create a fake "outgoing supply"
record.

------------------------------------------------------------------------

# Size Charts

Size Charts are reusable measurement profiles.

Purpose:

-   Standardize garment measurements
-   Allow multiple products to use the same measurement profile
-   Support virtual fitting

The Size Chart list can contain profiles such as:

-   Tailored Jacket Standard
-   Slim Fit Trousers
-   Heavyweight Knit Sweater
-   Oversized Classic

## Create New Size Chart

Fields:

### Chart Information

-   Chart Name
-   Category
-   Fit Type
-   Target
-   Unit
-   Description

### Available Sizes

Examples:

-   XS
-   S
-   M
-   L
-   XL
-   XXL

### Measurement Points

Examples:

-   Chest
-   Waist
-   Shoulder
-   Sleeve Length
-   Back Length
-   Hip
-   Neck

The user can add custom measurement points.

### Measurement Values

Store values per size.

Example:

``` text
Chest
XS: 88
S: 92
M: 96
L: 100
XL: 104
```

Do not show a "Profile Usage & Status" block on the create form if it
does not provide an actionable function.

A description field should be placed inside the Chart Information
section.

------------------------------------------------------------------------

# 3D Models

The 3D Model Library manages digital garment assets.

Supported model states:

-   Draft
-   Processing
-   Optimized

The library should show:

-   Model preview
-   SKU
-   Product name
-   File format
-   Version
-   Processing status

## Upload Model

Upload form should include:

-   Model Name
-   SKU
-   Associated Product
-   Model File
-   File Format
-   Version
-   Optional Description

After upload, the model can have a processing state.

The model should be assignable to a Product.

Do not duplicate the same model file inside Product Detail.

Product Detail should reference the model from the 3D Model Library.

------------------------------------------------------------------------

# Orders

Orders represent customer requests and finalized purchases.

## Customer Order Form

The customer submits:

``` text
Name
Address
Phone Number
Material
Product
Quantity by Size
Upload Design (optional)
Notes (optional)
```

Example:

``` text
Product: Custom Hoodie

Quantity:
S: 10
M: 20
L: 5
```

The order must support multiple sizes in the same order.

Do not assume that one order has only one size.

## Pricing Workflow

The customer does NOT enter the final price.

The workflow is:

``` text
Customer submits form
        ↓
Admin reviews order
        ↓
Admin contacts customer through WhatsApp
        ↓
Price is negotiated
        ↓
Admin enters final agreed price
        ↓
Order is confirmed
```

Only the price should be manually adjusted by the admin after customer
negotiation.

Product, material, quantity, and customer information should come from
the order submission.

## Order Management

Order list should contain:

-   Order ID
-   Date
-   Customer
-   Product
-   Quantity
-   Total
-   Status
-   Actions

Useful actions:

-   Details
-   Update
-   Set Price
-   Confirm
-   Cancel

## Order Status

Recommended statuses:

``` text
New
Under Review
Waiting Price
Confirmed
In Production
Completed
Cancelled
```

Avoid unnecessary status complexity.

------------------------------------------------------------------------

# Customer Data

The application does not need a separate complex Customer Directory for
the MVP.

Customer information can be stored as part of orders.

Customer data includes:

-   Name
-   Address
-   Phone Number
-   Order history

A dedicated Customer Directory is optional and should only exist if it
provides a clear benefit.

Do not duplicate customer information unnecessarily.

------------------------------------------------------------------------

# Production

Production should be kept simple for the hackathon.

Production is primarily an internal/admin process.

Customers do not need access to the internal production management page.

If implemented, production can track:

``` text
Confirmed
↓
Material Preparation
↓
Cutting & Sewing
↓
Quality Control
↓
Ready to Ship
↓
Completed
```

Do not build a complex manufacturing planning system.

The production page should support basic order status tracking only.

------------------------------------------------------------------------

# Analytics

Analytics is for historical and aggregated information.

Do not duplicate operational controls from Dashboard.

## KPI

Show:

-   Total Sales
-   Total Orders
-   Average Order Value
-   Average Fit Score

## Sales & Orders

Provide a chart showing sales and order trends over time.

Possible filters:

-   Last 7 Days
-   Last 30 Days
-   Last 90 Days
-   Custom Range

## Popular Products

Show products ranked by order frequency.

## Material Usage

Show material consumption by material.

Example:

``` text
Cotton Fleece
1,250 m

Baby Terry
820 m

Cotton Combed 24s
730 m
```

## Virtual Fitting Insights

Show:

-   Total Sessions
-   Average Fit Score
-   Most Tried Product
-   Most Recommended Size
-   Recommended Size Distribution

Analytics values should be derived from actual stored data where
possible.

Do not hardcode numbers that contradict the database.

------------------------------------------------------------------------

# Data Relationships

Keep data normalized.

Important relationships:

``` text
Product
 ├── Material(s)
 ├── Size Chart
 └── 3D Model

Order
 ├── Customer Information
 ├── Product
 ├── Material
 ├── Quantity by Size
 └── Final Price

Material
 ├── Stock
 ├── Reorder Level
 └── Stock Transactions

Size Chart
 └── Products

3D Model
 └── Product
```

Avoid duplicating the same information in multiple modules.

For example:

-   Product should reference a Size Chart
-   Product should reference a 3D Model
-   Order should reference the Product
-   Material stock should be managed from Materials
-   Analytics should calculate values from Orders, Products, Materials,
    and fitting data

------------------------------------------------------------------------

# UI and UX Rules

## General

Use consistent:

-   Typography
-   Spacing
-   Border styles
-   Button styles
-   Form controls
-   Status badges
-   Icons

Primary button:

Terracotta / burnt orange.

Secondary button:

White background with dark border.

Danger:

Use red only for destructive actions or warnings.

Success:

Use subtle green.

Do not overuse colors.

## Tables

Use clear column headers.

Keep row heights comfortable.

Status should use small badges.

Actions should be obvious but not visually dominant.

## Forms

Group related information into cards or sections.

Use clear labels above inputs.

Avoid unnecessarily large form fields.

Show validation errors close to the relevant field.

## Empty States

Every major list page should have a useful empty state.

Example:

``` text
No products found
Add your first product to start building your catalog.

+ New Product
```

## Loading States

Use skeletons or subtle loading indicators for asynchronous data.

Do not block the entire page unnecessarily.

------------------------------------------------------------------------

# Backend Principles

The frontend must not rely on duplicated hardcoded values when data
already exists elsewhere.

Examples:

-   Product count comes from products
-   Linked model count comes from product/model relationships
-   Low stock count comes from materials
-   Total orders comes from orders
-   Sales comes from finalized order prices
-   Material usage comes from stock transactions/order allocations

When an order is confirmed:

1.  Validate product
2.  Validate material
3.  Validate quantities
4.  Calculate required material
5.  Deduct stock
6.  Create stock transaction
7.  Update order status

Stock must never become negative unless explicitly allowed by the
business rules.

------------------------------------------------------------------------

# Hackathon Scope

Prioritize a reliable end-to-end workflow over excessive features.

## Must Work

-   Register
-   Login
-   Dashboard
-   Product CRUD
-   Material CRUD
-   Add Stock
-   Size Chart CRUD
-   3D Model upload/reference
-   Customer order submission
-   Order management
-   Manual final price entry
-   Order status updates
-   Automatic material stock deduction
-   Basic analytics

## Nice to Have

-   Virtual fitting integration
-   WhatsApp deep link
-   CSV export
-   Advanced charts
-   Advanced filtering
-   Production stage tracking

## Avoid

Do not build:

-   Real supplier API integration
-   Payment gateway
-   Automatic price negotiation
-   Complex ERP functionality
-   Complex procurement system
-   Complicated manufacturing planning
-   Unnecessary customer CRM features
-   Features that are only decorative

------------------------------------------------------------------------

# WhatsApp Integration

The application may provide a WhatsApp action for customer
communication.

The purpose is to make contacting the customer easy.

Example:

``` text
Contact Customer via WhatsApp
```

The actual price negotiation happens outside the application.

After agreement, the admin returns to the Order Detail page and enters:

``` text
Final Price
```

The application does not need to read WhatsApp messages.

------------------------------------------------------------------------

# Important Business Rules

1.  Customer submits order information through a form.
2.  Customer does not determine the final price.
3.  Admin negotiates the price through WhatsApp.
4.  Admin manually enters the final agreed price.
5.  One order can contain multiple sizes and quantities.
6.  Product and material data should be selected from existing records.
7.  Confirmed orders reduce material stock automatically.
8.  Adding inventory is done manually through `+ Add Stock`.
9.  Material stock increases when the admin records incoming stock.
10. There is no real supplier integration.
11. Production is an internal/admin process.
12. Analytics summarizes existing system data.
13. Dashboard focuses on current actions and operational status.
14. Do not duplicate data unnecessarily between pages.

------------------------------------------------------------------------

# Development Guidelines

Before implementing a new feature:

1.  Check whether the data already exists elsewhere.
2.  Reuse existing entities and relationships.
3.  Avoid creating duplicate database fields for the same concept.
4.  Keep business logic on the backend where appropriate.
5.  Keep UI components reusable.
6.  Maintain the existing Tigabenang design system.
7.  Make changes incrementally.
8.  Do not break existing navigation.
9.  Test the complete workflow after modifying related modules.

When a feature is not required for the core hackathon workflow, prefer
the simplest implementation.

------------------------------------------------------------------------

# Final Product Goal

The final Tigabenang system should clearly demonstrate:

``` text
Customer Order
      ↓
Admin Review
      ↓
WhatsApp Price Negotiation
      ↓
Admin Sets Final Price
      ↓
Order Confirmation
      ↓
Material Stock Deduction
      ↓
Production
      ↓
Completion
      ↓
Analytics
```

The interface should make this workflow easy to understand for both
users and hackathon judges.
