/***********************************************************************
 * Module:  Role.java
 * Author:  ayeta
 * Purpose: Defines the Class Role
 ***********************************************************************/

import java.util.*;

/** @pdOid 8cb45416-0fbb-44cc-943f-0d91bcdcf22b */
public class Role {
   /** @pdOid 23a575bc-a7e3-4dc2-8a98-3696ee680d33 */
   private String name;
   /** @pdOid be4b315d-3ff5-45ad-b70d-008bb4f02f7c */
   private String guard_name;
   
   /** @pdRoleInfo migr=no name=Permission assc=Association_2 coll=java.util.Collection impl=java.util.HashSet mult=0..* */
   public java.util.Collection<Permission> permission;
   
   
   /** @pdGenerated default getter */
   public java.util.Collection<Permission> getPermission() {
      if (permission == null)
         permission = new java.util.HashSet<Permission>();
      return permission;
   }
   
   /** @pdGenerated default iterator getter */
   public java.util.Iterator getIteratorPermission() {
      if (permission == null)
         permission = new java.util.HashSet<Permission>();
      return permission.iterator();
   }
   
   /** @pdGenerated default setter
     * @param newPermission */
   public void setPermission(java.util.Collection<Permission> newPermission) {
      removeAllPermission();
      for (java.util.Iterator iter = newPermission.iterator(); iter.hasNext();)
         addPermission((Permission)iter.next());
   }
   
   /** @pdGenerated default add
     * @param newPermission */
   public void addPermission(Permission newPermission) {
      if (newPermission == null)
         return;
      if (this.permission == null)
         this.permission = new java.util.HashSet<Permission>();
      if (!this.permission.contains(newPermission))
         this.permission.add(newPermission);
   }
   
   /** @pdGenerated default remove
     * @param oldPermission */
   public void removePermission(Permission oldPermission) {
      if (oldPermission == null)
         return;
      if (this.permission != null)
         if (this.permission.contains(oldPermission))
            this.permission.remove(oldPermission);
   }
   
   /** @pdGenerated default removeAll */
   public void removeAllPermission() {
      if (permission != null)
         permission.clear();
   }

}