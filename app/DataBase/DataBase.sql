/*
 Navicat PostgreSQL Data Transfer

 Source Server         : localhost
 Source Server Type    : PostgreSQL
 Source Server Version : 170004 (170004)
 Source Host           : localhost:5432
 Source Catalog        : template
 Source Schema         : public

 Target Server Type    : PostgreSQL
 Target Server Version : 170004 (170004)
 File Encoding         : 65001

 Date: 06/04/2025 14:00:13
*/


-- ----------------------------
-- Table structure for usuarios
-- ----------------------------
DROP TABLE IF EXISTS "public"."usuarios";
CREATE TABLE "public"."usuarios" (
  "id" uuid NOT NULL DEFAULT uuid_generate_v4(),
  "username" varchar(50) COLLATE "pg_catalog"."default" NOT NULL,
  "correo" varchar(100) COLLATE "pg_catalog"."default" NOT NULL,
  "nombre" varchar(100) COLLATE "pg_catalog"."default",
  "apellido" varchar(100) COLLATE "pg_catalog"."default",
  "password" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "rol" varchar(20) COLLATE "pg_catalog"."default" NOT NULL,
  "estado" varchar(20) COLLATE "pg_catalog"."default" NOT NULL DEFAULT 'active'::character varying,
  "ultimo_acceso" timestamp(6),
  "created_at" timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP,
  "updated_at" timestamp(6),
  "eliminado" int2 NOT NULL DEFAULT 0
)
;

-- ----------------------------
-- Records of usuarios
-- ----------------------------
INSERT INTO "public"."usuarios" VALUES ('d029c3e8-5b63-4506-aa1f-6a5137493212', 'leonardo1ss', 'asdsa33sd@gmail.com', 'Leonardo', 'Vazquez', '$2y$10$IfLbR0200DpEexmPLkwK7udch1WAVMcqsoNQf/tNA6n4OI/jlMSLW', 'usuario', 'inactivo', NULL, '2025-03-26 00:32:02.860846', '2025-03-27 22:35:39', 0);
INSERT INTO "public"."usuarios" VALUES ('aa7ecad0-12fa-440d-9ffe-a175486bd9d2', 'ing.leonardo2', 'asdsasssd@gmail.com', 'Leonardo', 'Vazquez', '$2y$10$kNnydQl8ekDU5b4Ql3ly6u7aGLmvGuzcngJAbM0K.Ah6AhwHqyUuy', 'admin', 'activo', NULL, '2025-03-26 00:29:55.259467', '2025-03-27 22:18:37', 0);
INSERT INTO "public"."usuarios" VALUES ('35a1ebb4-2bb2-4c80-a30f-feb2ad87f386', 'ing.leonardo', 'ing.leonardovaz@gmail.com', 'Leonardo', 'Vazquez', '$2y$10$H6sUCpITBfDjJZ0BVHJmB.XgbG4SoqCBVC5mcnuzz25awVB.UDKai', 'admin', 'activo', NULL, '2025-03-26 00:19:39.518708', '2025-03-27 22:32:02', 0);
INSERT INTO "public"."usuarios" VALUES ('45de7806-cc5f-4f09-85cf-dc8da758372b', 'leonardo1sss', 'asdasdss@gmail.com', 'Leonardo', 'Vazquez', '$2y$10$acgKok0FxujNH4e32VhdgOIatpqyt/NlbFT3j.ijTt0sCVH22simy', 'admin', 'activo', '2025-03-26 00:27:22.14948', '2025-03-26 00:27:22.14948', NULL, 0);
INSERT INTO "public"."usuarios" VALUES ('c56e4fcc-d45f-4961-902c-b0abfc165cdd', 'leonardo1ss2', 'asdsasd@gmail.com', 'asdadasd', 'asdasdasd', '$2y$10$KHLwUvC8gjtyBFmxVln4vOIIzVW9asvfaPubdy5y2/xukT8c8MrzG', 'admin', 'activo', NULL, '2025-03-26 00:29:19.307444', '2025-03-27 22:42:56', 0);

-- ----------------------------
-- Function structure for uuid_generate_v1
-- ----------------------------
DROP FUNCTION IF EXISTS "public"."uuid_generate_v1"();
CREATE OR REPLACE FUNCTION "public"."uuid_generate_v1"()
  RETURNS "pg_catalog"."uuid" AS '$libdir/uuid-ossp', 'uuid_generate_v1'
  LANGUAGE c VOLATILE STRICT
  COST 1;

-- ----------------------------
-- Function structure for uuid_generate_v1mc
-- ----------------------------
DROP FUNCTION IF EXISTS "public"."uuid_generate_v1mc"();
CREATE OR REPLACE FUNCTION "public"."uuid_generate_v1mc"()
  RETURNS "pg_catalog"."uuid" AS '$libdir/uuid-ossp', 'uuid_generate_v1mc'
  LANGUAGE c VOLATILE STRICT
  COST 1;

-- ----------------------------
-- Function structure for uuid_generate_v3
-- ----------------------------
DROP FUNCTION IF EXISTS "public"."uuid_generate_v3"("namespace" uuid, "name" text);
CREATE OR REPLACE FUNCTION "public"."uuid_generate_v3"("namespace" uuid, "name" text)
  RETURNS "pg_catalog"."uuid" AS '$libdir/uuid-ossp', 'uuid_generate_v3'
  LANGUAGE c IMMUTABLE STRICT
  COST 1;

-- ----------------------------
-- Function structure for uuid_generate_v4
-- ----------------------------
DROP FUNCTION IF EXISTS "public"."uuid_generate_v4"();
CREATE OR REPLACE FUNCTION "public"."uuid_generate_v4"()
  RETURNS "pg_catalog"."uuid" AS '$libdir/uuid-ossp', 'uuid_generate_v4'
  LANGUAGE c VOLATILE STRICT
  COST 1;

-- ----------------------------
-- Function structure for uuid_generate_v5
-- ----------------------------
DROP FUNCTION IF EXISTS "public"."uuid_generate_v5"("namespace" uuid, "name" text);
CREATE OR REPLACE FUNCTION "public"."uuid_generate_v5"("namespace" uuid, "name" text)
  RETURNS "pg_catalog"."uuid" AS '$libdir/uuid-ossp', 'uuid_generate_v5'
  LANGUAGE c IMMUTABLE STRICT
  COST 1;

-- ----------------------------
-- Function structure for uuid_nil
-- ----------------------------
DROP FUNCTION IF EXISTS "public"."uuid_nil"();
CREATE OR REPLACE FUNCTION "public"."uuid_nil"()
  RETURNS "pg_catalog"."uuid" AS '$libdir/uuid-ossp', 'uuid_nil'
  LANGUAGE c IMMUTABLE STRICT
  COST 1;

-- ----------------------------
-- Function structure for uuid_ns_dns
-- ----------------------------
DROP FUNCTION IF EXISTS "public"."uuid_ns_dns"();
CREATE OR REPLACE FUNCTION "public"."uuid_ns_dns"()
  RETURNS "pg_catalog"."uuid" AS '$libdir/uuid-ossp', 'uuid_ns_dns'
  LANGUAGE c IMMUTABLE STRICT
  COST 1;

-- ----------------------------
-- Function structure for uuid_ns_oid
-- ----------------------------
DROP FUNCTION IF EXISTS "public"."uuid_ns_oid"();
CREATE OR REPLACE FUNCTION "public"."uuid_ns_oid"()
  RETURNS "pg_catalog"."uuid" AS '$libdir/uuid-ossp', 'uuid_ns_oid'
  LANGUAGE c IMMUTABLE STRICT
  COST 1;

-- ----------------------------
-- Function structure for uuid_ns_url
-- ----------------------------
DROP FUNCTION IF EXISTS "public"."uuid_ns_url"();
CREATE OR REPLACE FUNCTION "public"."uuid_ns_url"()
  RETURNS "pg_catalog"."uuid" AS '$libdir/uuid-ossp', 'uuid_ns_url'
  LANGUAGE c IMMUTABLE STRICT
  COST 1;

-- ----------------------------
-- Function structure for uuid_ns_x500
-- ----------------------------
DROP FUNCTION IF EXISTS "public"."uuid_ns_x500"();
CREATE OR REPLACE FUNCTION "public"."uuid_ns_x500"()
  RETURNS "pg_catalog"."uuid" AS '$libdir/uuid-ossp', 'uuid_ns_x500'
  LANGUAGE c IMMUTABLE STRICT
  COST 1;

-- ----------------------------
-- Uniques structure for table usuarios
-- ----------------------------
ALTER TABLE "public"."usuarios" ADD CONSTRAINT "usuarios_nombre_usuario_key" UNIQUE ("username");
ALTER TABLE "public"."usuarios" ADD CONSTRAINT "usuarios_correo_electronico_key" UNIQUE ("correo");

-- ----------------------------
-- Primary Key structure for table usuarios
-- ----------------------------
ALTER TABLE "public"."usuarios" ADD CONSTRAINT "usuarios_pkey" PRIMARY KEY ("id");
