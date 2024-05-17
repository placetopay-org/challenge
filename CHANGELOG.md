# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org).

## [Unreleased]

# Release Notes for 1.6.x

## [1.6.7 (2024-05-09)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.6.7%0D1.6.6)

### Added
- Historical match by email rule is added. ([#1514](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1514))
- Historical match by mobile phone rule is added. ([#1516](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1516))
- Historical match by home phone rule is added. ([#1518](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1518))
- Historical match by device rule is added. ([#1531](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1531))
- Invalid transactions module. ([#1493](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1493))

### Changed
- Show the createdBy only if it exists in the guilty view. ([#1515](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1515))

## [1.6.6 (2024-04-30)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.6.6%0D1.6.5)

### Fixed
- Handle multiple responses from SisCard service when HTTP status code is different to 200. ([#1526](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1526))

## [1.6.5 (2024-04-26)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.6.5%0D1.6.4)

### Fixed
- Restore JavaScript interpolation in views. ([#1527](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1527))
- Exceptions are handled in the method url. ([#1527](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1527))

## [1.6.4 (2024-04-26)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.6.4%0D1.6.3)

### Added
- Configuration is created to send notifications to the issuer. ([#1519](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1519))
- Notification is created for issuers when a rule is updated, created or deleted. ([#1519](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1519))
- Show data of the means by which the OTP was sent. ([#1512](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1512))
- Configuration for custom subject for OTP is added. ([#1522](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1522))

### Fixed
- The way to import axios and a sha.js file is being corrected. ([#1524](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1524))

## [1.6.3 (2024-04-19)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.6.3%0D1.6.2)

### Changed
- Disable Throttle for api. ([#1517](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1517))

## [1.6.2 (2024-04-17)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.6.2%0D1.6.1)

### Added
- Add filter to get authentications with challenge. ([#1508](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1508))
- Implement Visa RBA extension. ([#1501](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1501))

### Changed
- Change franchise brand column to enumeration. ([#1415](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1415))

### Fixed
- Prevents KCV overwriting on subscription update. ([#1509](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1509))

## [1.6.1 (2024-04-10)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.6.1%0D1.6.0)

### Fixed
- Fix deprecation warnings reported after deploy using PHP 8.1 ([#1506](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1506))

## [1.6.0 (2024-04-10)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.6.0%0D1.5.31)

### Changed
- Support PHP 8.2 and Laravel 10, tests split. ([#1461](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1461))
- Deployment Docker image with PHP 8.2 support. ([#1502](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1502))
- Now the subscription form does not deactivate the franchise. ([#1502](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1502))

# Release Notes for 1.5.x

## [1.5.31 (2024-04-05)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.5.31%0D1.5.30)

### Changed
- Now authentication value keys are installed securely using asymmetric encryption. ([#1476](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1476))

## [1.5.30 (2024-04-01)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.5.30%0D1.5.29)

### Fixed
- Improve query performance using indexes in FeeTX transactions table. ([#1494](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1494))

## [1.5.29 (2024-03-26)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.5.29%0D1.5.28)

### Changed
- Fields from authentication data rule allow type multiple values as tags: acctID, acctType, acquirerBIN, acquirerMerchantID, threeDSServerOperatorID. ([#1488](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1488))

### Fixed
- Deny authentication when SisCard service responds with HTTP status code different to 200 and card error status code. ([#1483](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1483))
- Replace the same placeholder multiple times in message template editor. ([#1489](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1489))

### Removed
- Remove unused enum and created_at, updated_at columns in metrics table. ([#1487](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1487))

## [1.5.28 (2024-03-19)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.5.28%0D1.5.27)

### Added
- Add smart OTP validation in Diners OTP Service mock. ([#1480](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1480))

### Changed
- Improves in challenges metrics (table for save information and procedure). ([#1359](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1359))
- Update app-version to use token. ([#1480](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1480))
- Display the same data between the authentication flows metric and the authentication metric. ([#1306](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1306))

### Removed
- Remove old vapor production environment. ([#1381](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1381))

## [1.5.27 (2024-03-15)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.5.27%0D1.5.26)

### Changed
- Validate OTP strict comparaion for placetopay/diners. ([#1482](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1482))

## [1.5.26 (2024-03-13)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.5.26%0D1.5.25)

### Added
- Cardholder info text (cardholderInfo) setting to decoupled authentication. ([#1418](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1418))
- Implement PlaceToPay Filters package in transactions index. ([#1399](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1399))

### Changed
- Change header for consuming url notification route in SendCResToNotificationURLAction. ([#1472](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1472))

## [1.5.25 (2024-03-04)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.5.25%0D1.5.24)

### Fixed
- Validate Diners OTP to prevent authenticate with empty value. ([#1475](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1475))

## [1.5.24 (2024-02-20)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.5.24%0D1.5.23)

### Added
- Issuer message templates module to create custom emails and text messages. ([#1448](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1448))
- Send text message and Email OTP for non payment authentications. ([#1467](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1467))

### Fixed
- Reset ACL conditionals on model changes. ([#1468](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1468))

## [1.5.23 (2024-02-14)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.5.23%0D1.5.22)

### Added
- Dynamic Authentication data field in rule ([#1420](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1420))
- Use cache for transactions in final state until the end of the day in show transaction ([#1337](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1337))

### Changed
- KBA/OOB services respond error message on service error. ([#1366](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1366))
- Make field mcc multiple select in AuthenticationData rule. ([#1430](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1430))

## [1.5.22 (2024-02-12)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.5.22%0D1.5.21)

### Added
- Perform decoupled challenge when the threeRiiInd is 03 (ADD_CARD) , 04 (MAINTAIN_CARD_INFORMATION) and 05 (ACCOUNT_VERIFICATION) according Mastercard - AN 7792. ([#1456](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1456))
- Validate that prior authentication exists. (TransStatus 88 for Mastercard - AN 7792) ([#1446](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1446))

### Fixed
- Validate acs operator id for execute ul logic in challenges. ([#1460](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1460))

## [1.5.21 (2024-02-07)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.5.21%0D1.5.20)

### Added
- A notification service is added when the cardholder has completed OOB authentication. ([#1435](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1435))

### Changed
- It is validated that the routes (v1.challenge-response y v1.challenge) are signed and the security of the process is reinforced. ([#1278](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1278))

## [1.5.20 (2024-02-01)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.5.20%0D1.5.19)

### Changed
- Remove modal of rules creation. ([#1419](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1419))
- Improvements to import card ranges view. ([#1273](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1273))

## [1.5.19 (2024-01-25)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.5.19%0D1.5.18)

### Fixed
- Update java hsm cli for generate visa CAVV. ([#1450](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1450))

## [1.5.18 (2024-01-24)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.5.18%0D1.5.17)

### Added
- Create seeder to add new Sierra Leone currency. ([#1409](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1409))
- Disputes report implementation and tour for reports. ([#1416](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1416))
- Add translation to frequencies in show component. ([#1434](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1434))

### Fixed
- Filter disputes by issuer. ([#1303](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1303))

## [1.5.17 (2024-01-18)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.5.17%0D1.5.16)

### Added
- Device channel and protocol version in authentication index. ([#1379](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1379))
- Rule to aggregated purchase amount. ([#1417](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1417))

### Changed
- Invitation mail and instructions. ([#1302](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1302))

## [1.5.16 (2024-01-17)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.5.16%0D1.5.15)

### Added
- Remember last clicked tab. ([#1326](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1326))

### Changed
- Enable OAuth settings for testing services. ([#1301](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1301))

### Fixed
- No list configs in CardHolderAuthStrategy for mock services in Issuer settings and error exporting transactions. ([#1404](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1404))
- Forget cache when creating or updating country or currency models. ([#1325](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1325))

## [1.5.15 (2024-01-11)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.5.15%0D1.5.14)

### Fixed
- Truncate sensitive data in reports and fraud control rule names. ([#1356](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1356))

## [1.5.14 (2024-01-02)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.5.14%0D1.5.13)

### Added
- Issuer logo height in form. ([#1380](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1380))

### Changed
- Improve OTP label message for mobiles devices. ([#1370](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1370))

### Fixed
- Card ranges rules arguments. ([#1408](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1408))
- Removed duplicated method-url asset ([#1414](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1414))
- Imports module pagination and memory leak. ([#1310](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1310))

## [1.5.13 (2023-12-18)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.5.13%0D1.5.12)

### Added
- Ability to select CAVV key indicator for the Visa brand. ([#1407](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1407))

## [1.5.12 (2023-11-15)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.5.12%0D1.5.11)

### Changed
- Remove CAVV padding from Discover, received from cloud-hsm instead . ([#1400](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1400))

## [1.5.11 (2023-10-19)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.5.11%0D1.5.10)

### Added
- More information is added to the log to verify problems in decode and decrypt. ([#1401](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1401))

### Fixed
- Message is added when you want to edit a protected field, it is recorded. ([#1275](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1275))

## [1.5.10 (2023-10-19)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.5.10%0D1.5.9)

### Added
- Newrelic along cloudhsm image ([#1398](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1398))

## [1.5.9 (2023-10-18)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.5.9%0D1.5.8)

### Changed
- HRK currency is supported in transactions and deletion reports. ([#1397](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1397))

## [1.5.8 (2023-10-10)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.5.8%0D1.5.7)

### Changed
- Remove "useIndex" in transaction query ans cast in "whereIn" filter. ([#1395](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1395))

## [1.5.7 (2023-10-06)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.5.7%0D1.5.6)

### Fixed
- Validate encrypted field to resolve inconsistencies in reports ([#1392](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1392))

## [1.5.6 (2023-10-04)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.5.6%0D1.5.5)

### Fixed
- Clean json before decode in CReq incoming request. ([#1390](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1390))

## [1.5.5 (2023-09-29)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.5.5%0D1.5.4)

### Changed
- Policy implementation of the reporting package is updated by update. ([#1388](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1388))

## [1.5.4 (2023-09-28)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.5.4%0D1.5.3)

### Fixed
- Dependencies are updated to resolve errors with inconsistencies in the number of records in reports. ([#1386](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1386))

## [1.5.3 (2023-09-25)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.5.3%0D1.5.2)

### Added
- Added interaction logs using HSM, PCI 3DS requirement. ([#1384](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1384))
- Repositories are updated for installation of openjdk-11. ([#1385](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1385))

## [1.5.2 (2023-09-21)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.5.2%0D1.5.1)

### Fixed
- Fix empty Content-Type issue when log is enabled. ([#1382](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1382))

## [1.5.1 (2023-09-20)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.5.1%0D1.5.0)

### Added
- Enable dynamic configuration for logging incoming requests. ([#1381](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1381))

## [1.5.0 (2023-09-14)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.5.0%0D1.4.13)

### Added
- AWS Cloud HSM integration. Crypto operations are performed using the Java CLI tool on local or cloud provider. ([#1281](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1281))

# Release Notes for 1.4.x

## [1.4.21 (2023-10-11)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.4.21%0D1.4.20)

### Changed
- HRK currency is supported in transactions and deletion reports. ([#1396](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1396))

## [1.4.20 (2023-10-10)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.4.20%0D1.4.19)

### Changed
- Remove "useIndex" in transaction query and cast in "whereIn" filter. ([#1395](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1395))

## [1.4.19 (2023-10-06)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.4.19%0D1.4.18)

### Fixed
- Validate encrypted field to resolve inconsistencies in reports ([#1393](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1393))

## [1.4.18 (2023-10-05)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.4.18%0D1.4.17)

### Fixed
- Clean json before decode in CReq incoming request. ([#1391](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1391))

## [1.4.17 (2023-09-29)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.4.17%0D1.4.16)

### Changed
- Policy implementation of the reporting package is updated by update. ([#1388](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1388))

## [1.4.16 (2023-09-28)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.4.16%0D1.4.15)

### Fixed
- Dependencies are updated to resolve errors with inconsistencies in the number of records in reports.. ([#1387](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1387))

## [1.4.15 (2023-09-20)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.4.15%0D1.4.14)

### Fixed
- Fix empty Content-Type issue when log is enabled. ([#1382](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1382))

## [1.4.14 (2023-09-20)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.4.14%0D1.4.13)

### Added
- Enable dynamic configuration for logging incoming requests. ([#1381](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1381))

## [1.4.13 (2023-09-13)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.4.13%0D1.4.12)

### Fixed
- Content type error for version 2.1.0 authentications. ([#1376](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1376))

## [1.4.12 (2023-09-13)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.4.12%0D1.4.11)

### Fixed
- Error when an incorrect content-type is sent when the challenge is abandoned. ([#1374](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1374))

## [1.4.11 (2023-09-13)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.4.11%0D1.4.10)

### Changed
- Data elements are removed from the transaction trace messages to comply with the PCI matrix. ([#1259](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1259))

## [1.4.10 (2023-09-11)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.4.10%0D1.4.9)

### Changed
- ACS returns N instead of U when Siscard services returns error message. ([#1367](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1367))

## [1.4.9 (2023-09-11)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.4.9%0D1.4.8)

### Changed
- Allow non-standard content type (utf-8 lowercase). ([#1368](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1368))

## [1.4.8 (2023-09-04)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.4.8%0D1.4.7)

### Added
- Add BIN size setting for FeeTX reports. ([#1341](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1341))
- Amount, currency and merchant are added in the OOB service request. ([#1328](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1328))

## [1.4.7 (2023-08-29)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.4.7%0D1.4.6)

### Changed
- Query optimization for profiles and authorizations. ([#1284](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1284))

## [1.4.6 (2023-08-29)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.4.6%0D1.4.5)

### Changed
- Query optimization for filters. ([#1282](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1282))
- Queries related to acl are optimized. ([#1283](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1283))

## [1.4.5 (2023-08-21)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.4.5%0D1.4.4)

### Changed
- When creating an issuer, it separates the default and available services. ([#1276](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1276))
- The franchise is loaded from the relationship with the transaction. ([#1277](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1277))

### Fixed
- Show related authentications by issuer in decoupled authentications. ([#1280](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1280))

## [1.4.4 (2023-08-17)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.4.4%0D1.4.3)

### Added
- Support to 3RI recurring payment ECI for Mastercard. ([#1274](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1274))
- Custom ACS reference number for each franchise. ([#1274](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1274))
- Support to custom Visa challenge indicator (82) exemption. ([#1274](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1274))

### Changed
- Improve content type verification for x-www-form-urlencoded. ([#1274](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1274))
- 3RI NPA authentications with Visa 3RI indicator (80) are processed as PA. ([#1274](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1274))
- Improve to Erro responses processing from DS on send RReq. ([#1274](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1274))

### Fixed
- Acknowledgment name and version matching. ([#1274](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1274))

## [1.4.3 (2023-08-14)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.4.3%0D1.4.2)

### Added
- Indicator metric for disputes vs action. ([#1213](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1213))
- Indicator metric for disputes vs modality (result). ([#1214](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1214))

### Changed
- Reduce requests and database queries in dispute metrics. ([#1346](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1346))

## [1.4.2 (2023-08-10)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.4.2%0D1.4.1)

### Fixed
- Process many records in reporting. ([#1340](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1340))

## [1.4.1 (2023-08-04)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.4.1%0D1.4.0)

### Added
- Add Challenges report metric. ([#1231](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1231))

## [1.4.0 (2023-07-24)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.4.0%0D1.3.0)

### Added
- Visa Digital Authentication Framework DAF integration. ([#1227](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1227))
- Visa DAF indicador to the CAVV. ([#1235](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1235))

# Release Notes for 1.3.x

## [1.3.0 (2023-07-17)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.3.0%0D1.2.8)

### Added
- Allow to choose an available authentication method. ([#1221](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1221))

# Release Notes for 1.2.x

## [1.2.9 (2023-07-13)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.2.9%0D1.2.8)

### Fixed
- Transaction export when phone data is missing. ([#1338](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1338))

## [1.2.8 (2023-07-11)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.2.8%0D1.2.7)

### Fixed
- Save transaction status reason when challenge is completed. ([#1255](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1255))
- Handle exception for concurrent transactions with the same uuid. ([#1271](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1271))

## [1.2.7 (2023-07-10)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.2.7%0D1.2.6)

### Added
- Information is added to the show transaction view ([#1254](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1254))

### Fixed
- Duplicate questionnaire service traces. ([#1208](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1208))

## [1.2.6 (2023-07-07)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.2.6%0D1.2.5)

### Fixed
- Set right indicator for each supported IP version in the Discover CAVV. ([#1331](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1331))

## [1.2.5 (2023-07-07)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.2.5%0D1.2.4)

### Fixed
- Report generation with AWS SQS driver. ([#1327](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1327))

## [1.2.4 (2023-07-06)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.2.4%0D1.2.3)

### Fixed
- Verification of supported devices. ([#1330](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1330))

## [1.2.3 (2023-07-06)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.2.3%0D1.2.2)

### Fixed
- Generate CAVV with all IP versions. ([#1329](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1329))

## [1.2.2 (2023-06-20)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.2.2%0D1.2.1)

### Fixed
- Inconsistency with metrics when country of authentication is null. ([#1324](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1324))

## [1.2.1 (2023-06-02)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.2.1%0D1.2.0)

- Prevent install develop dependencies in deploy. ([e7a11f8](https://bitbucket.org/placetopay/threedsecure-acs/commits/e7a11f88fd876efff544aa84a446de67e985c93c))
- Remove calendar extension from Composer requirements. ([1df481f](https://bitbucket.org/placetopay/threedsecure-acs/commits/1df481f88f5582d6c7e4d2284b5c01b35b4b1607))
- Remove non used code. ([a3120e8](https://bitbucket.org/placetopay/threedsecure-acs/commits/a3120e87bdd4993846f4ebf82bdb741b85ce53cd))
- Add default timestampt to whitelists table. ([25644f2](https://bitbucket.org/placetopay/threedsecure-acs/commits/25644f2ee1c2a2fafcbf806a9ea8ce81ec933e9f))

## [1.2.0 (2023-06-01)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.2.0%0D1.1.43)

### Added
- Support for Laravel 9 and PHP 8. ([#1171](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1171))
- Indicator metric for disputes vs responsible agent. ([#1212](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1212))
- Add bin 8 lengths in card ranges for data to display in reports. ([#1241](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1241))

# Release Notes for 1.1.x

## [1.1.43 (2023-05-31)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.1.43%0D1.1.42)

### Fixed
- A user with admin role can remove roles from a profile. ([#1318](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1318))
- Update Discover CAVV algorithm. ([#1319](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1319))

## [1.1.42 (2023-05-19)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.1.42%0D1.1.41)

### Fixed
- Fix for truncate request and responses in logs for 3DS Services. ([#1313](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1313))

## [1.1.41 (2023-05-19)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.1.41%0D1.1.40)

### Fixed
- Prevent store cardholder phones without country code. ([#1314](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1314))

## [1.1.40 (2023-05-18)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.1.40%0D1.1.39)

### Removed
- Error notification in OTP and cardholder services. ([#1298](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1298))

## [1.1.39 (2023-05-18)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.1.39%0D1.1.38)

### Added
- Option to keep session active.

## [1.1.38 (2023-05-16)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.1.38%0D1.1.37)

### Fixed
- The method now properly handles cases where it is passed null as an argument. ([#1311](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1311))

## [1.1.37 (2023-05-11)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.1.37%0D1.1.36)

### Fixed
- An error occurs when searching for the RBA message extension in the first position. ([#1309](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1309))

## [1.1.36 (2023-05-02)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.1.36%0D1.1.35)

### Changed
- Update schema redis config.

## [1.1.35 (2023-04-17)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.1.35%0D1.1.34)

### Changed
- Improve database using indices in transactions, migrate from varchar to char, and enums.

### Fixed
- Fix Erro responses processing from DS on send RReq.

## [1.1.34 (2023-03-13)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.1.34%0D1.1.33)

### Changed
- FeeTX Reports are no longer created by issuer, the reports unite all the issuer's data by configuration. ([#1230](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1230))

## [1.1.33 (2023-03-13)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.1.33%0D1.1.32)

### Changed
- OnUpdate and OnDelete events are removed from foreign keys. ([#1261](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1261))

## [1.1.32 (2023-03-01)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.1.32%0D1.1.31)

### Added
- Scheme in default and cache redis config.

### Changed
- Write/read configuration database is allowed.

## [1.1.31 (2023-02-28)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.1.31%0D1.1.30)

### Added
- New reason column in authentications report. ([#1256](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1256))

### Fixed
- Missing data in authentications report. ([#1256](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1256))

## [1.1.30 (2023-02-16)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.1.30%0D1.1.29)

### Changed
- The Common Name in certificates must not be a domain value. ([#1253](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1253))

## [1.1.29 (2023-02-16)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.1.29%0D1.1.28)

### Fixed
- Certificates fields are optionals ([#1251](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1251))

## [1.1.28 (2023-02-14)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.1.28%0D1.1.27)

## Fixed
- Error loading profiles index view. ([#1250](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1250))

## [1.1.27 (2023-02-14)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.1.27%0D1.1.26)

## Added
- Issuer can choose a CAVV algorithm in the franchise subscription. ([#1203](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1203))

### Changed
- The otp shipping template that is sent by mail is changed. ([#1223](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1223))
- Removed button and route to create profiles. ([#1234](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1234))
- Add missing authentications translations, translation of strategies in traces. ([#1237](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1237))

### Fixed
- Fix in created by filter use RouteKeyName. ([#1244](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1244))

## [1.1.26 (2023-02-08)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.1.26%0D1.1.25)

### Added
- Displays the authentication value visible at the top of the index. ([#1228](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1228))
- Add the information of the traces of the services to the information when exporting a transaction in PDF. ([#1232](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1232))

### Changed
- Truncate sensitive information. ([#1229](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1229))

### Fixed
- Save authentication and eci for flow with OTP. ([#1228](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1228))

## [1.1.25 (2023-01-17)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.1.25%0D1.1.24)

### Fixed
- Update composer packages (acl 5.1.2: fix query to filter by model). ([#1217](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1217))

## [1.1.24 (2023-01-03)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.1.24%0D1.1.23)

### Added
- Indicator metric for disputes. ([#1175](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1175))

### Changed
- Update invitation instructions. ([#1206](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1206))
- Hide dropdown item if report is not complete. ([#1207](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1207))
- Reduce queries to process unresolved transactions. ([#1215](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1215))

### Fixed
- Fix visa authentication value. (Julian Date).  ([#1219](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1219))
- Handle invalid JSON content on decode CReq message from App. ([#1202](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1202))
- Fix in email invitations message. ([#1206](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1206))
- Add default queue for testing environments. ([#1207](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1207))
- The cardholder can change the OTP target. ([#1201](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1201))
- Amount column of the metrics table has been extended to support large amounts. ([#1209](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1209))
- Amount helper now handle large numeric values. ([#1209](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1209))

## [1.1.23 (2022-11-29)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.1.23%0D1.1.22)

### Changed
- Disable throttle middleware for API routes. ([#1205](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1205))

### Fixed
- Comparison with casting to detect 8 digits bin in reports. ([#1205](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1205))

## [1.1.22 (2022-11-28)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.1.22%0D1.1.21)

### Fixed
- Report processing is optimized by improving queries and updating columns. ([#1204](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1204))

## [1.1.21 (2022-11-10)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.1.21%0D1.1.20)

### Changed
- Improvements to blames. ([#1194](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1194))
- Improve display SisCard service errors. ([#1195](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1195))

### Fixed
- Prevent challenge cancellation double request. ([#1191](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1191))
- Handle empty CReq with response without content. ([#1196](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1196))
- Empty answer result on validate OTP select question. ([#1197](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1197))
- Store cardholder data correctly when using SisCard service. ([#1198](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1198))

## [1.1.20 (2022-11-03)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.1.20%0D1.1.19)

### Changed
- Accept Erro message from DS as response of RReq message. ([#1188](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1188))
- Reduce duplicate queries for challenge targets. ([#1187](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1187))
- Adjustment is made to be able to access the detail of a transaction without AReq. ([#1186](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1186))

### Fixed
- Truncate cardholder sensitive data using SisCard strategy. ([#1184](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1184))
- Prevent resend OTP for complete transactions. ([#1185](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1185))

## [1.1.19 (2022-10-25)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.1.19%0D1.1.18)

### Changed
- Update FeeTx settings key. ([#1182](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1182))

### Fixed
- Prevent generate duplicate FeeTx data on generate reports on demand. ([#1182](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1182))

## [1.1.18 (2022-10-24)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.1.18%0D1.1.17)

### Added
- Notification for bins out of range in authentication endpoint. ([#1170](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1170))
- BI procedures were created (countries and franchises). ([#1177](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1177))

### Changed
- BI procedures were updated (transactions). ([#1177](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1177))
- It is validated that the transaction with challenge has a target in the GenerateFeeTxData process. ([#1178](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1178))
- Message tracking date and time update parse is adjusted to accept null dates. ([#1176](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1176))

## [1.1.17 (2022-10-19)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.1.17%0D1.1.16)

### Added
- FeeTX reports send notification in case of error. ([#1158](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1158))
- Command to generate FeeTx reports on demand. ([#1158](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1158))

### Changed
- FeeTX reports were enabled using a scheduled task. ([#1158](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1158))

## [1.1.16 (2022-10-12)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.1.16%0D1.1.15)

### Added
- Ability to store error message in challenge flow. ([#1166](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1166))

### Fixed
- Fix in store device info for method url controller. ([#1164](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1164))
- Fix in base64 decode for show method url info. ([#1165](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1165))
- Authenticate non payment transactions with target and without target. ([#1167](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1167))

## [1.1.15 (2022-10-10)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.1.15%0D1.1.14)

### Changed
- CRes for app devices now do not contain HTML tags. ([#1161](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1161))
- FeeTX reports were enabled using a scheduled task. ([#1158](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1158))

### Fixed
- Remove route to show Issuer settings in available settings section. ([#1159](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1159))
- Fix in ACLs options for issuers and franchise in index authentications filters, index decouple transactions filter and create reports. ([#1160](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1160))

## [1.1.14 (2022-10-06)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.1.14%0D1.1.13)

### Added
- Task to update transactions where trans_status field is null and set U as value. ([#1142](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1142))
- Ability to delete and create optional settings. ([#1155](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1155))

### Changed
- RReq message will be sent with messageExtension data from AReq message. ([#1143](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1143))
- Modified home metric by transaction status metric and reordered weekdays in bar chart. ([#1144](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1144))
- Corrected metric behavior by conversion rate. ([#1146](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1146))
- Improve transaction show view when trans_status field is null. ([#1142](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1142))
- Issuer settings module with translations and shared settings between services. ([#1155](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1155))

### Fixed
- Pagination error in decoupled transaction module. ([#1141](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1141))
- Multiple encryption of Issuer settings values when they are considered secure. ([#1155](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1155))
- Fix in generate reports, use ACLs and validate filters. ([#1154](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1154))

## [1.1.13 (2022-10-03)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.1.13%0D1.1.12)

### Added
- Traces for fraud control lists. ([#1150](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1150))
- Validation of mandatory fields in decoupled transaction flow is added. ([#1151](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1151))

### Changed
- Fraud control list IP checker now compare IP from AReq. ([#1150](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1150))

### Fixed
- Prevent duplicate destroy action on try delete a fraud control list. ([#1150](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1150))

## [1.1.12 (2022-09-29)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.1.12%0D1.1.11)

### Added
- Add confirmation modal for enable and disable countries, currencies, brands(franchises), fraudControlGroup, fraudControlRules, profiles, and settings. ([#1112](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1112))
- Authentication flow using fraud control lists. ([#1147](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1147))

### Changed
- All currencies shared to fraud control creation form. ([#1147](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1147))
- Disabled historical score rule and Issuer score rule. ([#1147](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1147))

### Fixed
- Corrects count of maximum number of attempts per challenge. ([#1145](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1145))

## [1.1.11 (2022-09-16)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.1.11%0D1.1.10)

### Added
- Logging validation errors on authentication request. ([#1133](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1133))

### Changed
- Improvements in input date at form and translations of fraud control list module. ([#1130](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1130))
- Deleted acquirer BIN column in transactions index. ([#1135](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1135))
- PHP CS Fixer upgraded to version 3. ([#994](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/994))
- Composer packages were upgraded to prepare Laravel upgrade to version 9. ([#1125](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1125))

### Fixed
- Fixed error to load the alphabetic code in transaction currency in otp-send endpoint. ([#1124](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1124))
- Corrected button behavior to filter metrics. ([#1134](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1134))
- Infinite page reload in decouple transaction module. ([#1137](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1137))
- Many redirects on filter by date in Dispute index. ([#1123](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1123))
- Access to common or platform device data of deviceInfo field. ([#1136](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1136))

## [1.1.10 (2022-09-14)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.1.10%0D1.1.9)

### Added
- Custom database queue driver with transactions retries. ([#1120](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1120))

### Changed
- Downgrade acknowledgement to V1 for MasterCard and Discover. ([#1129](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1129))

## [1.1.9 (2022-09-09)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.1.9%0D1.1.8)

### Changed
- Issuer slug is generate automatically on creating or editing. ([#1119](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1119))
- Data types in start_range and end_range fields in card ranges to bigint. ([#1126](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1126))

## [1.1.8 (2022-09-06)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.1.8%0D1.1.7)

### Changed
- Generate metrics with job and procedures. ([#1058](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1058))
- Improve performance to disputes index. ([#1116](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1116))
- Redirect on trying edit when invitation is accepted. ([#1118](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1118))

### Fixed
- ACL edition in profiles module. ([#1117](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1117))

### Removed
- User model in Entities namespace. ([#1115](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1115))

## [1.1.7 (2022-08-31)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.1.7%0D1.1.6)

### Added
- State U is added to the state list field in the transaction index. ([#893](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/893))

### Fixed
- Error when 3RI flows required challenge. ([#1086](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1086))
- Fix in transactions filters for "bin" and "last_four". ([#1106](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1106))
- Transaction namespace of traces queues will be updated by the scheduling task. ([#1111](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1111))

## [1.1.6 (2022-08-24)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.1.6%0D1.1.5)

### Changed
- Get all the currencies from the cache and not only the enabled ones. ([#1109](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1109))

### Fixed
- Add validation that returns an error message when the card number is not sent. ([#1107](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1107))
- Shared view for errors and challenge errors. ([#1108](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1108))
- Message extension overwriting. ([#1110](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1110))

## [1.1.5 (2022-08-22)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.1.5%0D1.1.4)

### Added
- Transaction traces for questionnaire and Out of Band services. ([#1094](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1094))
- Added descriptions for permission in roles. ([#1095](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1095))

### Changed
- The ordering of the countries in the metric filter is adjusted. ([#1099](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1099))
- PAYE questionnaire services supported. ([#1091](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1091))
- Only number limitation for inputs in authentications and reports. ([#1085](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1085))

### Fixed
- Decode DeviceInfo field with Base64Url on AReq from App device. ([#1096](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1096))
- OTP challenge answer validation with App device and the Diners strategy. ([#1100](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1100))

## [1.1.4 (2022-08-18)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.1.4%0D1.1.3)

### Added
- Created PDF exportable for the transaction information. ([#1083](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1083))
- Added section with transaction identifiers to transaction detail view. ([#1089](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1089))
- Added searcher for card ranges in issuer card ranges detail. ([#1090](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1090))
- Added translations to messages in transaction traces. ([#1093](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1093))

### Changed
- Upgrade laravel to version 8.([#1076](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1076))

## [1.1.3 (2022-08-09)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.1.3%0D1.1.2)

## Added
- PAYE authentication option added. ([#1068](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1068))
- Added issuer and franchise data that uses the certificate in index and show certificates views. ([#1077](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1077))

## Changed
- Services authentication is divided by options. ([#1068](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1068))
- Optimized authenticate endpoint.([#1075](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1075))

## [1.1.2 (2022-08-03)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.1.2%0D1.1.1)

### Changed
- Improve storage of certificates and keys on disk ([#1065](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1065))

## [1.1.1 (2022-08-02)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.1.1%0D1.1.0)

### Changed
- Optimized challenge endpoint.([#1050](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1050))
- Added detail of challenge type in CRes message. ([#1057](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1057))
- Modified component for add alphabetic order to fields of type select. ([#1069](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1069))
- BI procedures were updated ([#1078](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1078))

### Fixed
- Fix node warnings ([#1074](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1074))

## [1.1.0 (2022-07-27)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.1.0%0D1.0.9)

### Fixed
- Updated base package version to support nullable transaction status. ([#1073](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1073))

### Changed
- Refactored code and bug fixes for UL certification. ([#1036](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1036))

# Release Notes for 1.0.x

## [1.0.9 (2022-07-22)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.0.9%0D1.0.8)

### Fixed
- Add support to base64 to CReq ([#1070](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1070))

## [1.0.8 (2022-07-19)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.0.8%0D1.0.7)

### Changed
- Questionnaire challenge allows to iterate for each question and check all answers. ([#1049](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1049))
- Second factor authentication results code is calculated with authentication method. ([#1059](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1059))
- Improve challenge views. ([#1056](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1056))

### Added
- Added legends for required fields in brand subscription create form. ([#1054](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1054))

### Fixed
- Encoding CReq with Base64Url on challenge cancel form. ([#1062](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1062))

## [1.0.7 (2022-07-18)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.0.7%0D1.0.6)

### Added
- Button to resend OTP in challenge view. ([#1064](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1064))

## [1.0.6 (2022-07-15)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.0.6%0D1.0.5)

### Added
- Log is added to get the response of the brand that is generating an error.([#1060](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1060))

## [1.0.5 (2022-07-08)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.0.5%0D1.0.4)

### Fixed
- Fix bug in show certificate view when trying to remove a certificate.([#1053](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1053))
- Fix error in setCertificate sending error notification to DS ([#1055](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1055))

## [1.0.4 (2022-07-07)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.0.4%0D1.0.3)

### Added
- Support for Out of Band Issuer settings. ([#1047](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1047))
- Support for questionnaire service for issuers. ([#1027](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1027))

### Changed
- Stored procedures for product monitoring are updated. ([#1041](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1041))
- Refactored ProcessingFlows classes according to UL certification branch. ([#1034](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1034))
- Grouped settings services in issuers. ([#1040](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1040))
- Improve performance to see decoupled transaction. ([#1039](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1039))

### Fixed
- Fix bug in create and edit countries forms.([#1048](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1048))

## [1.0.3 (2022-06-23)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.0.3%0D1.0.2)

### Changed
- Refactored TranslateFormUrlEncoded middleware.([#1009](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1009))
- Refactored CertifyCardholderData, LogIncomingRequest, SendNotificationToDSAfterAuthentication and UpdateTransactionStatus listeners according to UL certification. ([#1021](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1021))
- Refactored ChallengeCompleted event and UpdateTransactionStatus listener according to changes in UL branch. ([#1022](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1022))
- Refactor setter in challenge types factories. ([#1025](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1025))
- Refactor Erro message and base Message class according to changes in UL. ([#1026](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1026))
- Refactored ResultStepValidator according to changes in UL. ([#1028](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1028))
- Refactored ResultRequestService. ([#1029](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1029))
- Updated app-version command, use VersionFile::read() over VersionFile::readSha(). ([#1042](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1042))

### Added
- Added card ranges to support UL tests. ([#1014](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1014))
- Added fraud control rules to support UL tests. ([#1016](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1016))
- Added missing actions and text colors for fraud control rules with A, I, U and R statuses. ([#1018](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1018))

## [1.0.2 (2022-06-17)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.0.2%0D1.0.1)

### Changed
- Improve logs on sending or validating OTP with Diners strategy. ([#1033](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1038))

## [1.0.1 (2022-06-07)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.0.1%0D1.0.0)

### Fixed
- Fix bug when sending a message extension in the CReq. ([#1033](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1033))

## [1.0.0 (2022-06-07)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.0.0%0D1.0.0-rc.52)

### Added
- Add V2 in Acknowledgement for message extension app interaction with challengue . ([#1008](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1008))
- Response with Error message when the AReq message has invalid or duplicate UUID. ([#993](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/993))

### Changed
- Refactored authenticate service. ([#1000](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1000))
- Refactored challenge service. ([#1003](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1003))
- Refactored BrwAuthenticationStep.([#1007](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1007))
- Dispatch transactions traces with "traces" queue. ([#1006](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1006))
- Refactor ResultRequestServiceMock and SendErrorNotificationToDirectoryServer listener according to UL branch. ([#1023](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1023))

### Fixed
- Change bin length from Card-Ranges seeder. ([#1024](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1024))
- Search TX by ID regardless of date ([#1010](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1010))

### Removed
- Removed unnecessary rule builders to validate ThreeDS messages. ([#1005](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1005))
- Removed unused ThreeDS constants. ([#1011](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1011))

## [1.0.0-rc.52 (2022-06-01)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.0.0-rc.52%0D1.0.0-rc.51)

### Fixed
- Authentication service settings are validated and exception added. ([#1019](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1019))
- Increase ip length in device table. ([#1020](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1020))
- Message encoding to send CReq to AReq notification URL. ([#1017](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/1017))

### Added
- Add Authorization OAuth strategy configuration for Issuers. ([#984](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/984))

### Changed
- Constants are changed to those of the base package in tests/Feature/Api/V1/Authentication/BRW. ([#971](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/971))
- Constants are changed to those of the base package in AuthenticationWithMasterCardBrandTest and AuthenticationTracesTest. ([#972](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/972))
- Constants are changed to those of the base package in tests/Feature/Api/V1/Challenge. ([#973](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/973))
- Constants are changed to those of the base package in feature/tests. ([#974](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/974))
- Constants are changed to those of the base package in tests/Unit/Builders/Messages/Errors. ([#975](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/975))
- Constants are changed to those of the base package in tests/Unit/Builders/Messages/Requests. ([#976](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/976))
- Constants are changed to those of the base package in tests/Unit/Builders/Messages/Responses. ([#977](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/977))
- Constants are changed to those of the base package in tests/Unit/Challenge, tests/Unit. ([#978](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/978))
- Constants are changed to those of the base package in Encryption, Factories and FeeTxTransactions unit tests. ([#979](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/979))
- Constants are changed to those of the base package in tests/Unit/FraudControl. ([#980](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/980))
- Constants are changed to those of the base package in tests/Unit/FraudControl/Rules. ([#981](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/981))
- Constants are changed to those of the base package in tests/Unit/Jobs. ([#982](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/982))
- Constants are changed to those of the base package in CReqTest. ([#983](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/983))
- Changed ACS constants for base package constants in tests/Unit/ProcessingFlows. ([#988](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/988))
- Changed ACS constants for base package constants in tests/Unit/ProcessingFlows to 210 and 220 versions. ([#989](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/989))
- Changed ACS constants for base package constants in tests/Unit/Services. ([#990](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/990))
- Constants are changed to those of the base package in MessageBuilderError ([#909](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/909))
- Rename Franchise for Brand in views. ([#999](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/999))

## [1.0.0-rc.51 (2022-05-16)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.0.0-rc.51%0D1.0.0-rc.50)

### Added
- The execution of the SendRReqAfterRequestorMaxTime job is conditioned only for decoupled transactions. ([#986](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/986))

### Changed
- Prevent N+1 queries in jobs on query Issuer settings: VerifyTransactionAfterChallengeTimeout, VerifyTransactionWithoutFirstCReq. ([#987](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/987))
- Constants are changed to those of the base package in resources/views/admin/transaction. ([#965](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/965))
- Constants are changed to those of the base package in tests/Concerns. ([#966](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/966))
- Constants are changed to those of the base package in tests/Feature/Admin/DecoupledTransaction. ([#968](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/968))
- Constants are changed to those of the base package in transactions feature tests. ([#969](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/969))
- Constants are changed to those of the base package in tests/Feature/Api/V1. ([#970](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/970))
- Add database and resources views folders in conditional for pipeline. ([#873](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/873))

## [1.0.0-rc.50 (2022-05-11)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.0.0-rc.50%0D1.0.0-rc.49)

### Changed
- Changed ACS constants for base package constants in ThreeDS/ProcessingFlows/Concerns. ([#949](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/949))
- Changed ACS constants for base package constants in ThreeDS/ProcessingFlows/V210. ([#950](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/950))
- Changed ACS constants for base package constants in ThreeDS/ProcessingFlows/V220. ([#951](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/951))
- Changed ACS constants for base package constants in AuthenticationDecisionFactory. ([#952](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/952))
- Changed ACS constants for base package constants in ResultRequestService. ([#955](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/955))
- Changed ACS constants for base package constants in ThreeDS/Services/ULInfo. ([#956](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/956))
- Changed ACS constants for base package constants in ResultStepValidator. ([#957](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/957))
- Changed ACS constants for base package constants in View/Models. ([#958](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/958))
- Changed ACS constants for base package constants in database/factories. ([#959](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/959))
- Changed ACS constants for base package constants in database/migrations. ([#960](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/960))
- Changed ACS constants for base package constants in resources/lang. ([#961](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/961))
- Constants are changed to those of the base package in views. ([#962](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/962))
- Constants are changed to those of the base package in resources/views/admin/disputes. ([#964](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/964))

## [1.0.0-rc.49 (2022-05-09)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.0.0-rc.49%0D1.0.0-rc.48)

### Added
- Laravel Telescope for local development. ([#985](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/985))

### Changed
- Constants are changed to those of the base package in Middleware domain. ([#933](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/933))
- Constants are changed to those of the base package in Events, FraudControl, Helpers domain. ([#928](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/928))
- Constants are changed to those of the base package in Request domain. ([#930](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/930))
- Constants are changed to those of the base package in Controllers/Api, View/Composers. ([#938](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/938))
- Changed ACS constants for base package constants in HasWhiteListing and IsCancellable traits and OTPTargetTextQuestion. ([#939](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/939))
- Changed ACS constants for base package constants in ThreeDS/Factories module. ([#942](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/942))
- Changed ACS constants for base package constants in EciGenerator. ([#943](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/943))
- Changed ACS constants for base package constants in MessageErrorHandler. ([#944](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/944))
- Changed ACS constants for base package constants in ThreeDS/Messages/Requests. ([#946](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/946))
- Changed ACS constants for base package constants in ThreeDS/Messages/Responses. ([#947](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/947))
- Changed ACS constants for base package constants in ThreeDS/ProcessingFlows. ([#948](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/948))
- Remove un used traits (V_210/HasTransactionStatus,  V_220/HasTransactionStatus). ([#963](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/963))

### Deleted
- Deleted unused HasFieldsToAddToRules trait. ([#939](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/939))

## [1.0.0-rc.48 (2022-05-05)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.0.0-rc.48%0D1.0.0-rc.47)

### Fixed
- Base64url for deviceInfo instead of base64 ([#967](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/967))

## [1.0.0-rc.47 (2022-05-04)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.0.0-rc.47%0D1.0.0-rc.46)

### Changed
- Constants are changed to those of the base package in AcsRenderingType ([#901](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/901))
- Changed ACS constants for base package constants, in AuthenticationValue and Eci modules. ([#913](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/913))
- Constants are changed to those of the base package in Requests/V210. ([#924](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/924))
- Constants are changed to those of the base package in Requests/V220. ([#925](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/925))
- Constants are changed to those of the base package in Responses/V210. ([#926](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/926))
- Constants are changed to those of the base package in Responses/V220. ([#927](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/927))
- Changed ACS constants for base package constants in VerifyTransactionAfterChallengeTimeout job. ([#935](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/935))
- Changed ACS constants for base package constants in UpdateUnresolvedTransactions job. ([#936](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/936))
- Changed ACS constants for base package constants in VerifyTransactionWithoutFirstCReq job. ([#937](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/937))
- Changed ACS constants for base package constants in Ui data builders. ([#940](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/940))
- Changed ACS constants for base package constants in ThreeDS/Constants module. ([#941](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/941))
- Changed ACS constants for base package constants in ThreeDS/Messages. ([#945](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/945))

## [1.0.0-rc.46 (2022-04-26)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.0.0-rc.46%0D1.0.0-rc.45)

### Changed
- Constants are changed to those of the base package in SaveTransactionMessage, SendErrorNotificationToDirectoryServer, SendNotificationToDSAfterAuthentication listeners. ([#902](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/902))
- Constants are changed to those of the base package in Metrics domain. ([#903](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/903))
- Constants are changed to those of the base package in Mocks domain. ([#904](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/904))
- Constants are changed to those of the base package in Reports domain. ([#907](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/907))
- Constants are changed to those of the base package in Services domain. ([#908](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/908))
- Changed ACS constants for base package constants, in actions, commands and entities modules. ([#911](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/911))

### Fixed
- Set authentication type in aRes from config. ([#929](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/929))

## [1.0.0-rc.45 (2022-04-23)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.0.0-rc.45%0D1.0.0-rc.44)

### Added
- Added functionality that allows decoupled challenge in card ranges, modified create and update card ranges form and added decoupled parameter to the index and show views. ([#898](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/898))

### Changed
- Constants are changed to those of the base package in VerifyTransactionWithoutFirstCReq. ([#899](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/899))
- Constants are changed to those of the base package in SendRReqAfterRequestorMaxTime. ([#900](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/900))

### Fixed
- Generate ECI with full data ([#919](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/919))
- Deadlock error with jobs is corrected ([#923](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/923))

## [1.0.0-rc.44 (2022-04-22)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.0.0-rc.44%0D1.0.0-rc.43)

### Fixed
- OS version for mobile is not always collected ([#918](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/918))
- Certify cardholder data verification for no targets ([#915](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/915))
- ECI is added in RReq message ([#916](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/916))
- Maximum execution time validation is included in the SendTargetOTP job ([#917](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/917))

## [1.0.0-rc.43 (2022-04-22)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.0.0-rc.43%0D1.0.0-rc.42)

### Fixed
- Take client/server certificate in ds connection ([#914](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/914))

## [1.0.0-rc.42 (2022-04-21)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.0.0-rc.42%0D1.0.0-rc.41)

### Changed
- Diners traces in transactions now display code description readable for humans. ([#886](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/886))
- Applied improvements to logs description in all project. ([#897](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/897))
- Renamed threeDS jobs. ([#897](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/897))
- Improved transaction verification after challenge timeout. ([#897](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/897))

### Removed
- Deleted unused actions to verify challenge timeout from kernel. ([#897](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/897))
- Removed metric listeners. ([#910](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/910))
- Removed transaction in feetx listeners. ([#912](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/912))

## [1.0.0-rc.41 (2022-04-18)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.0.0-rc.41%0D1.0.0-rc.40)

### Changed
- Drop browser support restrictions in ACS. ([#895](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/895))

## [1.0.0-rc.40 (2022-04-12)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.0.0-rc.40%0D1.0.0-rc.39)

### Fixed
- Fix exchange rate base endpoint config. ([#894](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/894))
- Fix handle errors and logging on sync exchanges command. ([#894](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/894))

## [1.0.0-rc.39 (2022-04-08)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.0.0-rc.39%0D1.0.0-rc.38)

### Fixed
- Fix in get certificates for subscribe franchise in issuers (get client/server certificate). ([#890](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/890))

## [1.0.0-rc.38 (2022-04-07)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.0.0-rc.38%0D1.0.0-rc.37)

### Changed
- Change SDK for Signing in certificates (code and views). ([#885](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/885))
- Updated base package version with missing transaction statuses reasons for VISA. ([#879](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/879))

### Added
- Created fraud control rule for validate a card range. ([#863](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/863))

## [1.0.0-rc.37 (2022-04-06)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.0.0-rc.37%0D1.0.0-rc.36)

## Add
- Add new field to timestamp current message ([a997bd](https://bitbucket.org/placetopay/threedsecure-acs/commits/a997bde515dad7e6d6d4ada28c76c4fb584f9553), [b3e864](https://bitbucket.org/placetopay/threedsecure-acs/commits/b3e864010bd7fd12a1ee2b82e6d5bed84271eb02))
- Add Unresolved Transaction Updater (scheduled job) ([ab60ad2](https://bitbucket.org/placetopay/threedsecure-acs/commits/ab60ad22f22dd0d17d937fa1237e9ab7c1bf3950))
- Logs for card ranges, imports, issuer bins, profiles ([a55b60](https://bitbucket.org/placetopay/threedsecure-acs/commits/a55b606cbde70e1c281853a7f9ad20a1b4d5451f), [d7fd41](https://bitbucket.org/placetopay/threedsecure-acs/commits/d7fd410bea43c039a94117992a4c6dbbbf206de1))
- Transaction index displays the OS badge and UA badge. ([59abab8](https://bitbucket.org/placetopay/threedsecure-acs/commits/59abab8b71e6cc6da4cb072e33968ae4db13f4af))
- Add signing certificate to franchise subscription. ([4c9e1bc](https://bitbucket.org/placetopay/threedsecure-acs/commits/4c9e1bc84851b0cd7185526bf7ca26b2a0f668e4)), ([4f572f2](https://bitbucket.org/placetopay/threedsecure-acs/commits/4f572f212332e9008c9746fbde019d197d194183)), ([7ed74e1](https://bitbucket.org/placetopay/threedsecure-acs/commits/7ed74e1e60a4aeefba88b7e41595ac3be0191494)), ([3c473ed](https://bitbucket.org/placetopay/threedsecure-acs/commits/3c473ed569fdc5f331514ab35b5f35ae6f33c323)), ([29e65f5](https://bitbucket.org/placetopay/threedsecure-acs/commits/29e65f57c90d128e53926cb4721ac3bb7f4f2e86)), ([2bd09b4](https://bitbucket.org/placetopay/threedsecure-acs/commits/2bd09b42835ba23a16bdab1889ed2a1db1fe89b2))

### Changed
- Logo viewer routes now have a dedicated controller. ([e28bf49](https://bitbucket.org/placetopay/threedsecure-acs/commits/e28bf49d4a4ef97b9d3277a42316ea43c220131e))
- Card range table optimizations. ([aa7b775](https://bitbucket.org/placetopay/threedsecure-acs/commits/aa7b775411b4097a18fce48195a697210ccae8d0), [95b6fc](https://bitbucket.org/placetopay/threedsecure-acs/commits/95b6fc89691cb9882100f54bb6a898fac5eff55c), [5c611d](https://bitbucket.org/placetopay/threedsecure-acs/commits/5c611d53cd44c74a0ed517ec362049dfb85e757b))
- Bin field is removed from the create and update card ranges form. ([1d22ccc](https://bitbucket.org/placetopay/threedsecure-acs/commits/1d22ccca8636633d3f88353ed9c315f0fd1c2d08)), ([e396bf4](https://bitbucket.org/placetopay/threedsecure-acs/commits/e396bf481d84880a5afc94a048031164bf3dac1d))
- Query optimizations in transaction index. ([272d02b](https://bitbucket.org/placetopay/threedsecure-acs/commits/272d02b056abc41c853f3ba173138f0cbd685c78))
- Link is changed to view transaction details. ([b769d72](https://bitbucket.org/placetopay/threedsecure-acs/commits/b769d72773c3c4de2732ac90f5e627d86fe6ce0e)), ([3d961ea](https://bitbucket.org/placetopay/threedsecure-acs/commits/3d961ea29557af682629d16be95f0b088f0783cc))
- A start date of two days is set by default for date ranges. ([4c3a987](https://bitbucket.org/placetopay/threedsecure-acs/commits/4c3a987f380582d65447ffdcae54cb69c30bac95)), ([85e7d4c](https://bitbucket.org/placetopay/threedsecure-acs/commits/85e7d4cc84ead79f75afbcf06561159f20fc71bb))
- Card range import now support BIN's with 6 digits. ([cbd03c2](https://bitbucket.org/placetopay/threedsecure-acs/commits/cbd03c220f211ff813a2fb184577a2a181f41ee5))

## [1.0.0-rc.36 (2022-04-04)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.0.0-rc.36%0D1.0.0-rc.35)

### Fixed
- Async OTP for diners service does not catch errors. ([#880](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/880))
- Fix handler for OTP errors in JSON. ([#881](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/881))

## [1.0.0-rc.35 (2022-03-30)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.0.0-rc.35%0D1.0.0-rc.34)

### Added
- AuthenticationType identification has been added. ([#877](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/877))
- ECI has been added when transStatus is U in 2.1.0 version. ([#877](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/877))

### Fixed
- Field payTokenSource has been removed. ([#877](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/877))

## [1.0.0-rc.34 (2022-03-24)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.0.0-rc.34%0D1.0.0-rc.33)

### Changed
- Throw Exception when exchange rates not found and return message type Erro. ([#859](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/859))

### Added
- Stored procedures for product monitoring are added. ([#872](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/872))
- Added translations for the currencies, and it changed forms and field type to json. ([#861](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/861))
- Discover support and certification. ([#809](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/809))

## [1.0.0-rc.33 (2022-03-16)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.0.0-rc.33%0D1.0.0-rc.32)

### Changed
- Retry sending the RReq message according to Req 240 of 3DS protocol. ([#841](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/841))
- Refactor HomeMetric data visualization ([#860](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/860))
- Authentication method support with dynamic value depending on challenge (OTP implementation) ([#865](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/865))
- The request logs are adjusted to show the most relevant information. ([#866](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/866))
- Add ECI value when transStatus is U ([#867](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/867))
- Improvements in pipeline (shell scripts and conditionals). ([#848](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/848))

### Fixed
- Fixed code smells ([#870](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/870))

## [1.0.0-rc.32 (2022-02-24)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.0.0-rc.32%0D1.0.0-rc.31)

### Added
- Show button for truncated email in show transactions view. ([#842](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/842))
- Franchise filter for transactions and decouple transactions. ([#847](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/847))

### Fixed
- Error when send OTP ([#846](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/846))

### Changed
- Add support to Mastercard Identity Check Platform Updates AN 4805 ([#718](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/718))

## [1.0.0-rc.31 (2022-02-17)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.0.0-rc.31%0D1.0.0-rc.30)

### Added
- Add KCV in subscription form. ([#843](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/843))

## [1.0.0-rc.30 (2022-02-11)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.0.0-rc.30%0D1.0.0-rc.29)

### Added
- Search in the users module. ([#830](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/830))
- User timezone support. ([#822](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/822))
- Validation is added so that bin is not inside a bin . ([#837](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/837))

## [1.0.0-rc.29 (2022-02-10)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.0.0-rc.29%0D1.0.0-rc.28)

### Added
- Validation is added to not allow duplicate bins by issuer. ([#834](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/834))

### Changed
- Newsletter AI11604. Return TransStatusReason 13 when cardholder is not enrolled in service. ([#833](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/833))

## [1.0.0-rc.28 (2022-02-08)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.0.0-rc.28%0D1.0.0-rc.27)

### Fixed
- Query and process to list security logs are optimized. ([#821](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/821))

### Removed
- Transaction traces are removed from the security logs module. ([#823](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/823))

### Changed
- Visual improvements in certificates close to expire notification message. ([#826](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/826))
- Improve pagination style. ([#829](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/829))

## [1.0.0-rc.27 (2022-02-03)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.0.0-rc.27%0D1.0.0-rc.26)

### Changed
- CAVV key set for interdin ([#828](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/828))

## [1.0.0-rc.26 (2022-02-03)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.0.0-rc.26%0D1.0.0-rc.25)

### Changed
- Add support to processing of NPA transaction to VISA AI10361 ([#744](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/744))

## [1.0.0-rc.25 (2022-01-29)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.0.0-rc.25%0D1.0.0-rc.24)

### Changed
- Prevent duplicate challenge form submit. ([#818](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/818))

## [1.0.0-rc.24 (2022-01-24)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.0.0-rc.24%0D1.0.0-rc.23)

### Changed
- Decrypt private key to send RReq. ([#817](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/817))

## [1.0.0-rc.23 (2022-01-13)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.0.0-rc.23%0D1.0.0-rc.22)

### Added
- http-headers package implementation. ([#756](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/756))

### Fixed
- Display the Issuer logo on download dispute report. ([#797](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/797))

### Changed
- New design system to issuer options menu.  ([#790](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/790))
- Report card range exception to sentry. ([#802](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/802))
- Allow to parameterize the charset and collation fields in environment vars  ([#803](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/803))

## [1.0.0-rc.22 (2022-01-06)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.0.0-rc.22%0D1.0.0-rc.21)

### Added
- Report method is added in ResultRequestService when an exception occur ([#810](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/810))

## [1.0.0-rc.21 (2022-01-05)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.0.0-rc.21%0D1.0.0-rc.20)

### Added
- Add x-frame-options (Allow From) ([#807](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/807))

## [1.0.0-rc.20 (2022-01-04)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.0.0-rc.20%0D1.0.0-rc.19)

### Changed
- Get acs url by config. ([#804](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/804))

## [1.0.0-rc.19 (2021-12-09)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.0.0-rc.19%0D1.0.0-rc.18)

### Fixed
- Validation of inacive rules by issuer is corrected. ([#798](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/798))

## [1.0.0-rc.18 (2021-12-01)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.0.0-rc.18%0D1.0.0-rc.17)

### Removed
- Remove locale relationship from Issuer module. ([#642](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/642))

### Added
- Display default values from 3DS protocol on rule creation with authentication data. ([#761](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/761))
- Pure transaction traces. ([#748](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/748))
- ECI is added for Discover. ([#791](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/791))
- Implementing CAVV algorithm for Discover ([#771](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/771))

### Changed
- Refactoring linked fraud control groups ([#750](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/750))
- Refactoring of method that validates a certificate for conflicts in steam  ([#770](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/770))
- Charts using Highcharts library. ([#774](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/774))
- Bins of 6 and 8 are supported in creating a range of cards. ([#793](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/793))

### Fixed
- Translations in conversion rate chart. ([#762](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/762))
- Update vulnerable UA-parser-js package, update dependencies. ([#775](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/775))
- Reset filters feature in metrics module. ([#777](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/777))
- Error was corrected when validating a certificate. ([#787](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/787))

## [1.0.0-rc.17 (2021-11-11)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.0.0-rc.17%0D1.0.0-rc.16)

### Added
- Created device fingerprint match rule to fraud control. ([#537](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/537))
- Added translations for Authentication Request fields in the trace. [#765](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/765)
- Confirmation modal to dispute. ([#751](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/751))
- Display fraud control group name when rule execute group. ([#757](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/757))
- Enter keys for MasterCard and Visa by issuer franchise ([#729](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/729))
- Data of the keys of the issuer's franchise is loaded in the update form ([#776](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/776))

### Changed
- Pagination with system design styles. ([#737](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/737))
- Changed organization name in certificate seeder. ([#752](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/752))
- Added improvements to card display, created notification email and added additional information to log. ([#760](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/760))
- Modified BIN rule with specific length in authentication filters. ([#767](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/767))
- Query improvements in index and show views ([#742](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/742))
- Validation order is changed to see if a transaction requires challenge by otp ([#779](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/779))
- Changed Vapor Project ID. ([#784](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/784))

### Fixed
- Improve reliability rating ([#747](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/747))
- Too many requests when authentications are filtered per year. ([#746](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/746))
- Add enabled at in issuer query ([#749](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/749))
- Add setting parent when issuer is created ([#753](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/753))
- Delete option transposes into list of values ([#766](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/766))
- Change validation to svg mimes ([#769](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/769))
- Mail variable is updated in environment file ([#778](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/778))
- Fix seeder name AuthenticationValueToTableIssuerFranchiseSeeder  ([#776](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/776))
- Safe data saving in a setting update form is corrected ([#779](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/779))
- Error in the validation message of the fields for entering the franchise keys by issuer is corrected ([#785](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/785))

## [1.0.0-rc.16 (2021-09-02)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.0.0-rc.16%0D1.0.0-rc.15)

### Added
- Speed condition rule. ([#724](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/724))
- Add additional settings in CardHolderInfoStrategy ([#679](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/679))
- Add confirmation when try to enable/disable an issuer. ([#699](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/699))
- When an issuer is disabled, authentications are not processed. ([#699](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/699))
- Commit, branch, and time in version ([#732](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/732))
- Paginate the rules and search over them  ([#702](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/702))

### Fixed
- The transaction allows the challenge when the cardholder has an email or a phone. ([#709](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/709))
- Remove html from OTP message to sms ([#713](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/713))
- Fix scope search for country model [#736](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/736)

### Changed
- Refactoring the issuer to configurations ([#315](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/315))
- Change env var to sentry integration [#730](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/730)

## [1.0.0-rc.15 (2021-08-25)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.0.0-rc.15%0D1.0.0-rc.14)

### Fixed
- Report Client Exception to Sentry in Accounts Token ([#724](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/724))

## [1.0.0-rc.14 (2021-08-24)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.0.0-rc.14%0D1.0.0-rc.13)

### Fixed
- Refactor transaction queries ([#721](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/721))
- Split login from complete authentication ([#723](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/723))

### Changed
- Change name field in profiles to non-unique ([#727](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/727))

## [1.0.0-rc.13 (2021-08-19)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.0.0-rc.13%0D1.0.0-rc.12)

### Fixed
- Improvement in the authentication process with accounts ([#717](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/717))

## [1.0.0-rc.12 (2021-08-13)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.0.0-rc.12%0D1.0.0-rc.11)

### Added
- Status messages while rule type data is loading to create fraud control rules.. ([#711](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/711))
- Sentry integration to front-end (Vue) [#671](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/671)
- Add notification flow in url method endpoint ([#678](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/678))

### Changed
- Transaction trace view including SReq and SRes. ([#573](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/573))
- PurchaseAmount rule now support currencies and LTE, LT, GTE, GT and BETWEEN operators [#701](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/701)
- Change sendOTP method to Api endpoint ([#704](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/704))

### Fixed
- Refresh fraud control cache. ([#688](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/688))
- Save OTP in Transaction and build OTP message. ([#698](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/698))
- Update buttons to save fraud control rule order, update notifications positions, translations from API Rest. ([#700](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/700))
- Search for the countries and currencies modules. ([#695](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/695))
- Validate the date format and PAN list type as is correct in the fraud control lists. ([#703](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/703))

## [1.0.0-rc.11 (2021-07-27)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.0.0-rc.11%0D1.0.0-rc.10)

### Added
- Add default currency to issuers ([#685](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/685))
- Added notification via email when the services associated with the challenge fail (Cardholder Info Service and OTP). ([#649](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/649))
- Adjust the passphrase field of the certificates table so that it is stored as a string and not as an object. ([#662](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/662))
- Added contextual statuses to fraud control lists. ([#650](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/650))
- Improve config to support authentication values for issuer ([#690](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/690))

### Changed
- Changed padding in views of translatable settings ([#669](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/669))

### Fixed
- Fix purchase amount format in challenge notification ([#579](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/579))

## [1.0.0-rc.10 (2021-07-19)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.0.0-rc.10%0D1.0.0-rc.9)

### Added
- Added information about user logins and logouts  ([#666](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/666))
- Add new metrics for authentications and refactoring of existing metrics ([#665](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/665))
- Add validation when the required settings, but the value is empty ([#670](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/670))
- Add in show view, the missing settings messages ([#670](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/670))

### Changed
- Certificate validation changed for subscription when an issuer it's enabled ([#670](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/670))

## [1.0.0-rc.9 (2021-07-15)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.0.0-rc.9%0D1.0.0-rc.8)

### Added
- Add support for bin 8 in feetx reports ([#661](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/661))
- Add the option to resolve decoupled authentications ([#637](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/637))

### Fixed
- Validation of the existence of the challenge in the update of the transaction in FeeTX ([#661](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/661))
- Truncate sensitive application data in logs ([#672](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/672))
- Add support for NPA (Non-Payment Authentications) in challenges ([#674](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/674))
- Add support for svg images for issuers's logo ([#675](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/675))

### Changed
- Application build with Webpack 5 ([#641](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/641))
- Split pipeline in steps (Feature Tests, Unit Tests, UL Tests, Coding Standards, FrontEnd Tests) ([#641](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/641))
- Changed input field type for bits selection in the creation of certificates. ([#667](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/667))

## [1.0.0-rc.8 (2021-07-06)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.0.0-rc.8%0D1.0.0-rc.7)

### Changed
- Changed the way a subscription is created for an Issuer to a franchise ([#648](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/648))

### Added
- Added option to delete certificates. ([#648](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/648))

## [1.0.0-rc.7 (2021-06-28)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.0.0-rc.7%0D1.0.0-rc.6)

### Added
- Added new roles related to an issuer. ([#628](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/628))
- Added more access control in the views. ([#628](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/628))
- Added FeeTx settings for BX+ bank in config-reports file  ([#645](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/645))
- SSL client certificate validation and expiration date field. ([#562](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/562))
- Added pagination package for all views ([#617](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/617))
- Register a configuration without a default value ([#639](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/639))

### Changed
- Default MD for CSR now is SHA256 ([#652](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/652))
- Card Range Rule min 13 max 19 length ([#643](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/643))

## [1.0.0-rc.6 (2021-06-24)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.0.0-rc.6%0D1.0.0-rc.5)

### Changed
- Email field in CSR form now is optional. ([#634](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/634))

### Fixed
- Return correct messageVersion when card range is null. ([#598](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/598))
- Layout system dropdowns were not clickable on the entire highlight zone. ([#580](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/580))
- Add baseUrl field to config of coreapi service. ([#635](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/635))
- Fixed bug on close the fraud control rules modal using escape. ([#614](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/614))
- Added Button to close warning alert by changes in rules order position. ([#615](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/615))

## [1.0.0-rc.5 (2021-06-23)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.0.0-rc.5%0D1.0.0-rc.4)

### Added
- Created settings fields to configure OTP URL and cardholder information URL in settings and issuers. ([#576](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/576))

### Changed
- Add again certificate chain validation against public key. ([#626](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/626))
- Changed way of obtaining URL for the OTP in the challenge flow for Diners. ([#583](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/583))
- Issuers logo dimensions with ratio range. ([#629](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/629))

### Fixed
- Fixed bug in rule group index in issuers. ([#627](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/627))

## [1.0.0-rc.4 (2021-06-22)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.0.0-rc.4%0D1.0.0-rc.3)

### Changed
- Quit certificate chain validation against public key. ([#626](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/626))

## [1.0.0-rc.3 (2021-06-21)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.0.0-rc.3%0D1.0.0-rc.2)

### Fixed
- Accept certificate chain in certificate module. ([622](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/622))

## [1.0.0-rc.2 (2021-06-21)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.0.0-rc.2%0D1.0.0-rc.1)

### Changed
- Change slug validation on certificate creation/edition. ([618](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/618))
- Authentication in Cardholder Mock Strategy. ([618](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/618))

## [1.0.0-rc.1 (2021-06-14)](https://bitbucket.org/placetopay/threedsecure-acs/branches/compare/1.0.0-rc.1%0D1.0.1-beta)

### Added
- Added Countries CRUD. ([#611](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/611)), ([#608](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/608))
- Added Persistent filters. ([#607](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/607))
- Added default order in lists. ([#605](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/605))
- Added group invitations. ([#609](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/609))
- Added account information. ([#609](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/609))
- Switch for profiles. ([#609](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/609))

### Changed
- Removed UAT deployment from Continuous delivery. ([#610](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/610))
- ACL updated. ([#606](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/606))
- Nav was ordered according to most used options. ([#604](https://bitbucket.org/placetopay/threedsecure-acs/pull-requests/604))
